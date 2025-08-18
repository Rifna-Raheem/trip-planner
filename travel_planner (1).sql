-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2025 at 08:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


-- Database: `travel_planner`
--

-- --------------------------------------------------------

--
-- Table structure for table `attractions`
--

CREATE TABLE `attractions` (
  `id` int(11) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `image_filename` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attractions`
--

INSERT INTO `attractions` (`id`, `location`, `name`, `image_filename`) VALUES
(1, 'Colombo', 'Gangaramaya Temple', 'gangaramaya_temple.jpg'),
(2, 'Colombo', 'Colombo National Museum', 'colombo_national_museum.jpg'),
(3, 'Colombo', 'Galle Face Green', 'galle_face_green.jpg'),
(4, 'Colombo', 'Lotus Tower', 'lotus_tower.jpg'),
(5, 'Colombo', 'Independence Memorial Hall', 'independence_memorial_hall.jpg'),
(6, 'Colombo', 'Pettah Floating Market', 'pettah_floating_market.jpg'),
(7, 'Kandy', 'Temple of the Tooth Relic', 'temple_of_the_tooth_relic.jpg'),
(8, 'Kandy', 'Royal Botanical Gardens', 'royal_botanical_gardens.jpg'),
(9, 'Kandy', 'Kandyan Cultural Dance Show', 'kandyan_cultural_dance_show.jpg'),
(10, 'Galle', 'Galle Fort', 'galle_fort.jpg'),
(11, 'Galle', 'Unawatuna Beach', 'unawatuna_beach.jpg'),
(12, 'Galle', 'Jungle Beach', 'jungle_beach.jpg'),
(13, 'Nuwara Eliya', 'Gregory Lake', 'gregory_lake.jpg'),
(14, 'Nuwara Eliya', 'Tea Plantations', 'tea_plantations.jpg'),
(15, 'Nuwara Eliya', 'Victoria Park', 'victoria_park.jpg'),
(16, 'Anuradhapura', 'Ruwanwelisaya Stupa', 'ruwanwelisaya_stupa.jpg'),
(17, 'Anuradhapura', 'Isurumuniya Temple', 'isurumuniya_temple.jpg'),
(18, 'Anuradhapura', 'Sri Maha Bodhi Tree', 'sri_maha_bodhi_tree.jpg'),
(19, 'Jaffna', 'Nallur Kandaswamy Temple', 'nallur_kandaswamy_temple.jpg'),
(20, 'Jaffna', 'Jaffna Fort', 'jaffna_fort.jpg'),
(21, 'Jaffna', 'Jaffna Public Library', 'jaffna_public_library.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `num_guests` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `booking_status` enum('confirmed','cancelled','completed') DEFAULT 'confirmed',
  `payment_status` enum('pending','paid','not required','Refund_requested') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `hotel_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `price_per_night` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`hotel_id`, `name`, `location`, `rating`, `price_per_night`, `description`, `image1`, `image2`, `image3`) VALUES
(1, 'Hilltop Haven', 'Kandy', 4.5, 120.00, 'Scenic mountain views in Kandy.', 'kandy1.jpg', 'kandy2.jpg', 'kandy3.jpg'),
(2, 'Lakeside Resort', 'Kandy', 4.3, 140.00, 'Modern amenities near Kandy Lake.', 'kandy4.jpg', 'kandy5.jpg', 'kandy6.jpg'),
(3, 'Kandy Palace', 'Kandy', 4.7, 160.00, 'Luxury stay in central Kandy.', 'kandy7.jpg', 'kandy8.jpg', 'kandy9.jpg'),
(4, 'Forest Edge Inn', 'Kandy', 4.1, 100.00, 'Peaceful retreat on forest edge.', 'kandy10.jpg', 'kandy11.jpg', 'kandy12.jpeg'),
(5, 'Royal Kandy Hotel', 'Kandy', 4.6, 135.00, 'Elegant and comfortable rooms.', 'kandy13.jpg', 'kandy14.jpg', 'kandy15.jpg'),
(6, 'Cultural View Hotel', 'Kandy', 4.0, 110.00, 'Close to Temple of the Tooth.', 'kandy16.jpg', 'kandy17.jpg', 'kandy18.jpg'),
(7, 'Green Gardens', 'Kandy', 3.9, 90.00, 'Budget hotel in green surroundings.', 'kandy19.jpg', 'kandy20.jpg', 'kandy21.jpg'),
(8, 'Heritage Hills', 'Kandy', 4.4, 125.00, 'Blend of tradition and modern.', 'kandy22.jpg', 'kandy23.jpg', 'kandy24.jpg'),
(9, 'The Kandy Leaf', 'Kandy', 4.2, 115.00, 'A modern hotel with natural charm.', 'kandy25.jpg', 'kandy26.jpg', 'kandy27.jpg'),
(10, 'Lake Breeze Hotel', 'Kandy', 4.3, 130.00, 'Facing Kandy Lake with great views.', 'kandy28.jpg', 'kandy29.jpg', 'kandy30.jpg'),
(11, 'Ocean View Inn', 'Colombo', 4.6, 150.00, 'Facing the beautiful Indian Ocean.', 'colombo1.jpg', 'colombo2.jpg', 'colombo3.jpg'),
(12, 'Colombo Central Hotel', 'Colombo', 4.3, 135.00, 'In the heart of the city.', 'colombo4.jpg', 'colombo5.jpg', 'colombo6.jpg'),
(13, 'Cityscape Hotel', 'Colombo', 4.4, 145.00, 'Modern rooms with skyline views.', 'colombo7.jpg', 'colombo8.jpg', 'colombo9.jpg'),
(14, 'Luxury Bay Inn', 'Colombo', 4.7, 170.00, 'Luxurious hotel by the sea.', 'colombo10.jpg', 'colombo11.jpg', 'colombo12.jpg'),
(15, 'Palm Grove Hotel', 'Colombo', 4.2, 125.00, 'Near shopping malls and parks.', 'colombo13.jpg', 'colombo14.jpg', 'colombo15.jpg'),
(16, 'Urban Stay', 'Colombo', 4.0, 110.00, 'Budget-friendly and clean.', 'colombo16.jpg', 'colombo17.jpg', 'colombo18.jpg'),
(17, 'Sunset Suites', 'Colombo', 4.5, 155.00, 'Famous for sunset views.', 'colombo19.jpg', 'colombo20.jpg', 'colombo21.jpg'),
(18, 'The Downtown Inn', 'Colombo', 4.1, 120.00, 'Perfect for business travelers.', 'colombo22.jpg', 'colombo23.jpg', 'colombo24.jpg'),
(19, 'Seaside Comfort', 'Colombo', 4.3, 140.00, 'Peaceful and near the beach.', 'colombo25.jpg', 'colombo26.jpg', 'colombo27.jpg'),
(20, 'The Lotus Hotel', 'Colombo', 4.6, 165.00, 'Elegant rooms and spa.', 'colombo28.jpg', 'colombo29.jpg', 'colombo30.jpg'),
(21, 'Fortress Stay', 'Galle', 4.5, 140.00, 'Inside the historic Galle Fort.', 'galle1.jpg', 'galle2.jpg', 'galle3.jpg'),
(22, 'Beach Edge Hotel', 'Galle', 4.4, 130.00, 'On the Unawatuna beach.', 'galle4.jpg', 'galle5.jpg', 'galle6.jpg'),
(23, 'Sea Breeze Resort', 'Galle', 4.6, 145.00, 'Cool breeze and calm waters.', 'galle7.jpg', 'galle8.jpg', 'galle9.jpg'),
(24, 'Old Dutch House', 'Galle', 4.1, 110.00, 'Colonial architecture and charm.', 'galle10.jpg', 'galle11.jpg', 'galle12.jpg'),
(25, 'Tropical Retreat', 'Galle', 4.3, 125.00, 'A peaceful tropical escape.', 'galle13.jpg', 'galle14.jpg', 'galle15.jpg'),
(26, 'Harbor View Hotel', 'Galle', 4.2, 135.00, 'Views of the Galle harbor.', 'galle16.jpg', 'galle17.jpg', 'galle18.jpg'),
(27, 'Galle Ocean Inn', 'Galle', 4.0, 100.00, 'Affordable and near beach.', 'galle19.jpg', 'galle20.jpg', 'galle21.jpg'),
(28, 'Sunrise Point', 'Galle', 4.5, 155.00, 'Unforgettable sunrise experience.', 'galle22.jpg', 'galle23.jpg', 'galle24.jpg'),
(29, 'Palm Bay Hotel', 'Galle', 4.3, 128.00, 'Perfect for families.', 'galle25.jpg', 'galle26.jpg', 'galle27.jpg'),
(30, 'Coconut Grove', 'Galle', 4.4, 135.00, 'Among coconut palms near sea.', 'galle28.jpg', 'galle29.jpg', 'galle30.jpg'),
(31, 'Tea Valley Resort', 'Nuwara Eliya', 4.6, 145.00, 'Nestled in tea plantations.', 'nuwara1.jpg', 'nuwara2.jpg', 'nuwara3.jpg'),
(32, 'Misty Mountain Inn', 'Nuwara Eliya', 4.4, 130.00, 'Cool weather and great views.', 'nuwara4.jpg', 'nuwara5.jpg', 'nuwara6.jpg'),
(33, 'Lake View Hotel', 'Nuwara Eliya', 4.5, 140.00, 'View of Gregory Lake.', 'nuwara7.jpg', 'nuwara8.jpg', 'nuwara9.jpg'),
(34, 'Highland Comforts', 'Nuwara Eliya', 4.2, 120.00, 'Perfect place for relaxing.', 'nuwara10.jpg', 'nuwara11.jpg', 'nuwara12.jpg'),
(35, 'Royal Tea Estate Inn', 'Nuwara Eliya', 4.7, 160.00, 'Live like a tea estate owner.', 'nuwara13.jpg', 'nuwara14.jpg', 'nuwara15.jpg'),
(36, 'Green Mist Resort', 'Nuwara Eliya', 4.3, 125.00, 'Lush gardens and misty views.', 'nuwara16.jpg', 'nuwara17.jpg', 'nuwara18.jpg'),
(37, 'Horton Hill Hotel', 'Nuwara Eliya', 4.4, 135.00, 'Near Horton Plains park.', 'nuwara19.jpg', 'nuwara20.jpg', 'nuwara21.jpg'),
(38, 'Alpine Heights', 'Nuwara Eliya', 4.1, 115.00, 'Cool alpine-style stay.', 'nuwara22.jpg', 'nuwara23.jpg', 'nuwara24.jpg'),
(39, 'Colonial Cottage Inn', 'Nuwara Eliya', 4.0, 110.00, 'Cozy cottages with vintage feel.', 'nuwara25.jpg', 'nuwara26.jpg', 'nuwara27.jpg'),
(40, 'Foggy Valley Resort', 'Nuwara Eliya', 4.5, 150.00, 'Romantic and quiet getaway.', 'nuwara28.jpg', 'nuwara29.jpg', 'nuwara30.jpg'),
(41, 'Heritage Palace', 'Anuradhapura', 4.5, 130.00, 'Historic palace-style hotel.', 'anu1.jpg', 'anu2.jpg', 'anu3.jpg'),
(42, 'Sacred City Inn', 'Anuradhapura', 4.2, 115.00, 'Close to ancient ruins.', 'anu4.jpg', 'anu5.jpg', 'anu6.jpg'),
(43, 'Treehouse Retreat', 'Anuradhapura', 4.3, 120.00, 'Stay among trees and wildlife.', 'anu7.jpg', 'anu8.jpg', 'anu9.jpg'),
(44, 'Monk’s Rest', 'Anuradhapura', 4.0, 105.00, 'Quiet and peaceful lodging.', 'anu10.jpg', 'anu11.jpg', 'anu12.jpg'),
(45, 'Bodhi View Hotel', 'Anuradhapura', 4.4, 125.00, 'View of sacred Bodhi tree.', 'anu13.jpg', 'anu14.jpg', 'anu15.jpg'),
(46, 'Ancient Garden Inn', 'Anuradhapura', 4.1, 110.00, 'Beautiful garden-themed hotel.', 'anu16.jpg', 'anu17.jpg', 'anu18.jpg'),
(47, 'Royal Lotus Hotel', 'Anuradhapura', 4.6, 140.00, 'Elegant and well-furnished rooms.', 'anu19.jpg', 'anu20.jpg', 'anu21.jpg'),
(48, 'Sunrise Palace', 'Anuradhapura', 4.3, 120.00, 'Good for family travelers.', 'anu22.jpg', 'anu23.jpg', 'anu24.jpg'),
(49, 'Pagoda View Inn', 'Anuradhapura', 4.2, 118.00, 'View of dagobas nearby.', 'anu25.jpg', 'anu26.jpg', 'anu27.jpg'),
(50, 'Sacred Stupa Hotel', 'Anuradhapura', 4.4, 128.00, 'Next to ancient temples.', 'anu28.jpg', 'anu29.jpg', 'anu30.jpg'),
(51, 'Jaffna Heritage Stay', 'Jaffna', 4.3, 120.00, 'Learn Jaffna culture and food.', 'jaffna1.jpg', 'jaffna2.jpg', 'jaffna3.jpg'),
(52, 'Northern Breeze Inn', 'Jaffna', 4.1, 110.00, 'Cool winds and warm rooms.', 'jaffna4.jpg', 'jaffna5.jpg', 'jaffna6.jpg'),
(53, 'Cultural House', 'Jaffna', 4.4, 125.00, 'Near local markets and temples.', 'jaffna7.jpg', 'jaffna8.jpg', 'jaffna9.jpg'),
(54, 'Jaffna Bay View', 'Jaffna', 4.2, 115.00, 'Sea view and northern comfort.', 'jaffna10.jpg', 'jaffna11.jpg', 'jaffna12.jpg'),
(55, 'Fort Inn', 'Jaffna', 4.0, 100.00, 'Next to Jaffna Fort entrance.', 'jaffna13.jpg', 'jaffna14.jpg', 'jaffna15.jpg'),
(56, 'Palm Beach Lodge', 'Jaffna', 4.3, 120.00, 'Cozy beachside rooms.', 'jaffna16.jpg', 'jaffna17.jpg', 'jaffna18.jpg'),
(57, 'Northern Lights Inn', 'Jaffna', 4.1, 105.00, 'Budget and peaceful.', 'jaffna19.jpg', 'jaffna20.jpg', 'jaffna21.jpg'),
(58, 'Tamil Heritage Hotel', 'Jaffna', 4.5, 135.00, 'Rich Tamil culture experience.', 'jaffna22.jpg', 'jaffna23.jpg', 'jaffna24.jpg'),
(59, 'Island Breeze Resort', 'Jaffna', 4.2, 118.00, 'Private and scenic island view.', 'jaffna25.jpg', 'jaffna26.jpg', 'jaffna27.jpg'),
(60, 'Library View Stay', 'Jaffna', 4.4, 128.00, 'Next to famous Jaffna Library.', 'jaffna28.jpg', 'jaffna29.jpg', 'jaffna30.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `payer_name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) DEFAULT 'USD',
  `card_last4` varchar(10) DEFAULT NULL,
  `card_brand` varchar(50) DEFAULT NULL,
  `card_exp_month` varchar(10) DEFAULT NULL,
  `card_exp_year` varchar(10) DEFAULT NULL,
  `payment_intent_id` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`

--
-- Triggers `payments`
--
DELIMITER $$
CREATE TRIGGER `set_booking_payment_status` AFTER INSERT ON `payments` FOR EACH ROW BEGIN
    IF LOWER(NEW.status) = 'succeeded' THEN
        UPDATE bookings
        SET payment_status = 'paid'
        WHERE booking_id = NEW.booking_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `personal_details`
--

CREATE TABLE `personal_details` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `travel_style` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `travel_interests` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_details`

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `User_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `register`


--
-- Indexes for dumped tables
--

--
-- Indexes for table `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `hotel_id` (`hotel_id`),
  ADD KEY `fk_bookings_user` (`email`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_email`),
  ADD KEY `fk_hotel` (`hotel_id`),
  ADD KEY `fk_booking` (`booking_id`);

--
-- Indexes for table `personal_details`
--
ALTER TABLE `personal_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_id` (`email`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `Phone_number` (`Phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attractions`
--
ALTER TABLE `attractions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `personal_details`
--
ALTER TABLE `personal_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`),
  ADD CONSTRAINT `fk_bookings_user` FOREIGN KEY (`email`) REFERENCES `register` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_hotel` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_email`) REFERENCES `register` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `personal_details`
--
ALTER TABLE `personal_details`
  ADD CONSTRAINT `fk_email` FOREIGN KEY (`email`) REFERENCES `register` (`email`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
