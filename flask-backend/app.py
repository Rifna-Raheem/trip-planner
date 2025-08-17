# main Flask server to create suggestions
from flask import Flask, request, jsonify, render_template
from optimizer import genetic_optimize
from flask_cors import CORS
import mysql.connector

app = Flask(__name__)
CORS(app)



@app.route('/optimize', methods=['POST'])
def optimize():
    try:
        print("RAW JSON:", request.data)          # raw data bytes from request
        print("PARSED JSON:", request.get_json())  # parsed JSON object

        data = request.get_json()
        start = data["start"].strip().title()
        end = data["end"].strip().title()
        duration = int(data["duration"])
        cities = [city.strip().title() for city in data["cities"]]

# Ensure Start & End Are Included
        if start not in cities:
            cities.insert(0, start)
        if end not in cities:
            cities.append(end)

        # ✅ Add input validation
        if not start or not end or duration <= 0 or len(cities) < 2:
           return jsonify({"error": "Invalid input. Please check start, end, duration, and cities."}), 400


 # Generate and Return Suggestions
        suggestions = genetic_optimize(start, end, duration, cities)
        return jsonify(suggestions)

    except Exception as e:
        import traceback
        traceback.print_exc()   # <-- This will print full error in terminal
        return jsonify({"error": str(e)}), 500

# ---------- Attraction Image API ----------
@app.route("/get_attraction_images", methods=["POST"])
def get_attraction_images():
    data = request.get_json()
    attractions = data.get("attractions", [])

    if not attractions:
        return jsonify({"images": []})

    # Connect to your MySQL database
    connection = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",     # ✅ change to your MySQL password
        database="travel_planner"        # ✅ change to your DB name (e.g., trip_planner)
    )
    cursor = connection.cursor()

    # Prepare query
    placeholders = ', '.join(['%s'] * len(attractions))
    query = f"SELECT name, image_filename FROM attractions WHERE name IN ({placeholders})"
    cursor.execute(query, attractions)

    image_data = cursor.fetchall()
    connection.close()

    # Convert to dictionary
    images = {name: filename for name, filename in image_data}
    return jsonify({"images": images})


# ---------- Main Page Route (optional if needed) ----------
@app.route("/")
def home():
    return render_template("trip_schedular.html")  # or your actual landing page

# Start the Server
if __name__ == '__main__':
    app.run(debug=True)
