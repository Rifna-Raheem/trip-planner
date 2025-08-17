import random

# === Distance Dictionary ===
distance_dict = {
    ("Colombo", "Kandy"): 115, ("Colombo", "Galle"): 125, ("Colombo", "Nuwara Eliya"): 170,
    ("Colombo", "Anuradhapura"): 205, ("Colombo", "Jaffna"): 395,
    ("Kandy", "Galle"): 225, ("Kandy", "Nuwara Eliya"): 75, ("Kandy", "Anuradhapura"): 140,
    ("Kandy", "Jaffna"): 370, ("Galle", "Nuwara Eliya"): 240, ("Galle", "Anuradhapura"): 330,
    ("Galle", "Jaffna"): 510, ("Nuwara Eliya", "Anuradhapura"): 220, ("Nuwara Eliya", "Jaffna"): 460,
    ("Anuradhapura", "Jaffna"): 230,
}

# === Full Attractions Dictionary ===
places_by_city = {
    "Colombo": ["Gangaramaya Temple", "Colombo National Museum", "Galle Face Green", "Lotus Tower", "Independence Memorial Hall", "Pettah Floating Market"],
    "Kandy": ["Temple of the Tooth Relic", "Royal Botanical Gardens", "Kandyan Cultural Dance Show"],
    "Galle": ["Galle Fort", "Unawatuna Beach", "Jungle Beach"],
    "Nuwara Eliya": ["Gregory Lake", "Tea Plantations", "Victoria Park"],
    "Anuradhapura": ["Ruwanwelisaya Stupa", "Isurumuniya Temple", "Sri Maha Bodhi Tree"],
    "Jaffna": ["Nallur Kandaswamy Temple", "Jaffna Fort", "Jaffna Public Library"]
}

# === Famous Attractions (shorter subset for route) ===
famous_attractions = {
    "Colombo": ["Gangaramaya Temple", "Lotus Tower"],
    "Kandy": ["Temple of the Tooth Relic"],
    "Galle": ["Galle Fort"],
    "Nuwara Eliya": ["Gregory Lake"],
    "Anuradhapura": ["Ruwanwelisaya Stupa"],
    "Jaffna": ["Nallur Kandaswamy Temple"]
}

# === Distance, Cost, Time ===
def calculate_distance(route):
    total = 0
    for i in range(len(route) - 1):
        pair = (route[i], route[i + 1])
        rev_pair = (route[i + 1], route[i])
        total += distance_dict.get(pair) or distance_dict.get(rev_pair) or 100
    return total

def calculate_cost(dist):
    return round(dist * random.uniform(4.8, 5.2))

def calculate_time(dist):
    hours = round(dist / 40 + random.uniform(-0.5, 0.5), 1)
    return f"{hours} hrs"

# === Expand with famous attractions ===
def expand_with_famous_attractions(start, end, majors, max_attractions_per_city=1):
    full = [start]
    for city in majors:
        full.append(city)
        if city in famous_attractions:
            chosen = random.sample(famous_attractions[city], min(max_attractions_per_city, len(famous_attractions[city])))
            full.extend(chosen)
    full.append(end)
    return full

# === Simplify route: remove duplicate consecutive cities & only keep cities + famous attractions ===
def simplify_route(route):
    simplified = []
    cities = set(places_by_city.keys())
    famous_set = {a for atts in famous_attractions.values() for a in atts}

    for place in route:
        if place in cities or place in famous_set:
            if not simplified or simplified[-1] != place:  # avoid duplicates like Colombo -> Colombo
                simplified.append(place)
    return simplified

# === Get remaining attractions (excluding those used in the route) ===
def get_remaining_attractions(cities, used_attractions):
    remaining = []
    for city in cities:
        for att in places_by_city.get(city, []):
            if att not in used_attractions:
                remaining.append(att)
    return remaining

# === Genetic Algorithm ===
def generate_initial_population(cities, pop_size=200):
    pop = []
    for _ in range(pop_size):
        mid = cities[1:-1]
        random.shuffle(mid)
        pop.append([cities[0]] + mid + [cities[-1]])
    return pop

def fitness(route):
    return -calculate_distance(route)

def crossover(a, b):
    start = 1
    end = len(a) - 1
    slice_a = a[start:end]
    child = [a[0]] + slice_a + [a[-1]]
    for city in b[start:end]:
        if city not in slice_a:
            child.insert(-1, city)
    return child

def mutate(route, rate=0.15):
    r = route[1:-1]
    for i in range(len(r)):
        if random.random() < rate:
            j = random.randrange(len(r))
            r[i], r[j] = r[j], r[i]
    return [route[0]] + r + [route[-1]]

# === Single-City Mode (No GA) ===
def single_city_trip(city, duration):
    atts = places_by_city.get(city, [])
    random.shuffle(atts)
    selected = atts[:min(duration * 2, len(atts))]  # pick 2 attractions per day
    route = [city] + selected
    dist = len(selected) * 10  # rough distance estimate
    return [{
        "route": route,
        "attractions": [a for a in atts if a not in selected],
        "spend_time": [f"{random.randint(1,3)} hrs" for _ in route],
        "nights": [city] * duration,
        "total_distance": dist,
        "estimated_cost": calculate_cost(dist),
        "estimated_time": calculate_time(dist)
    }]

# === Main optimization ===
def genetic_optimize(start, end, duration, cities, pop_size=200, generations=150):
    # === Handle single-city trips ===
    unique_cities = set([start, end] + cities)
    if len(unique_cities) == 1:
        return single_city_trip(start, duration)

    # === Otherwise: Use GA ===
    full_with_famous = expand_with_famous_attractions(start, end, cities, max_attractions_per_city=1)
    pop = generate_initial_population(full_with_famous, pop_size)

    for _ in range(generations):
        scored = sorted(pop, key=fitness, reverse=True)
        elite = scored[:pop_size // 5]
        next_gen = elite[:]
        while len(next_gen) < pop_size:
            a, b = random.sample(elite, 2)
            child = mutate(crossover(a, b))
            next_gen.append(child)
        pop = next_gen

    final = sorted(pop, key=fitness, reverse=True)[:20]
    seen = set()
    unique = []
    for r in final:
        simplified = tuple(simplify_route(r))
        if simplified not in seen:
            unique.append(list(simplified))
            seen.add(simplified)
        if len(unique) >= 3:
            break

    suggestions = []
    for route in unique:
        dist = calculate_distance(route)
        used_attractions = [p for p in route if p not in places_by_city]
        remaining_attractions = get_remaining_attractions(cities, used_attractions)

        # === Daily Plan ===
        daily_plan = []
        for i in range(min(duration, len(route))):
            city = route[i]
            if city in places_by_city:
                activities = []
                for att in places_by_city[city][:2]:  # up to 2 attractions per day
                    activities.append({
                        "time": f"{random.randint(1,3)} hrs",
                        "name": att
                    })
                daily_plan.append({
                    "day": i+1,
                    "city": city,
                    "activities": activities
                })

        # === Photos ===
        photos = {}
        for city in cities:
            for att in places_by_city.get(city, []):
                photos[att] = f"https://source.unsplash.com/300x200/?{att.replace(' ', '%20')}"

        suggestions.append({
            "route": route,
            "attractions": remaining_attractions,
            "spend_time": [f"{random.randint(1,3)} hrs" for _ in route],
            "nights": route[1:1+min(len(route)-2, duration)],
            "total_distance": dist,
            "estimated_cost": calculate_cost(dist),
            "estimated_time": calculate_time(dist),
            "daily_plan": daily_plan,
            "photos": photos
        })
    return suggestions
