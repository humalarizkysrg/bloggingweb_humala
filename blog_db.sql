-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2025 at 10:42 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Technology', 'technology', '2025-06-12 11:00:32'),
(2, 'Business', 'business', '2025-06-12 11:00:32'),
(3, 'Lifestyle', 'lifestyle', '2025-06-12 11:00:32'),
(4, 'Sports', 'sports', '2025-06-12 11:00:32'),
(5, 'Entertainment', 'entertainment', '2025-06-12 11:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `excerpt` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `excerpt`, `image_url`, `featured`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'The Future of Artificial Intelligence', 'future-of-ai', 'Innovations in the field of artificial intelligence continue to shape the future of humanity across nearly every industry. AI is already the main driver of emerging technologies like big data, robotics and IoT, and generative AI has further expanded the possibilities and popularity of AI. \n\nAccording to a 2023 IBM survey, 42 percent of enterprise-scale businesses integrated AI into their operations, and 40 percent are considering AI for their organizations. In addition, 38 percent of organizations have implemented generative AI into their workflows while 42 percent are considering doing so.\n\nWith so many changes coming at such a rapid pace, here’s what shifts in AI could mean for various industries and society at large.', 'Exploring the latest developments in AI technology...', 'https://cdn.builtin.com/cdn-cgi/image/f=auto,fit=cover,w=1200,h=635,q=80/https://builtin.com/sites/www.builtin.com/files/2022-07/future-artificial-intelligence.png', 1, 1, '2025-06-12 11:00:32', '2025-06-12 11:51:16'),
(2, 'Top Business Trends for 2024', 'business-trends-2024', 'With the general global economic downturn predicted to get worse before it gets better, companies are likely to remain cautious when it comes to spending and investing in radical new ideas in 2024. However, there are a number of technological and societal trends that are simply too big to ignore or put off until better days. These are the areas where we can expect to see continued innovation and investment, and I\'ll highlight the most prominent in this article.\r\n\r\nAs has been the case for the past few years, there\'s some overlap between these and my other predictions, which focus primarily on technology. Simply put, this is because business trends today are largely driven by technology. However, as we develop a better understanding of a technology - artificial intelligence (AI) being the obvious example - we also understand what it isn\'t. In 2024, this will lead to new perspectives on what makes us human - a theme I believe is reflected in this year\'s predictions.', 'Discover the most important business trends...', 'https://imageio.forbes.com/specials-images/imageserve/651123d5c34b3f195bcb85e4/The-10-Biggest-Business-Trends-For-2024-Everyone-Must-Be-Ready-For-Now/960x0.jpg?format=jpg&width=1440', 1, 2, '2025-06-12 11:00:32', '2025-06-12 20:40:04'),
(3, 'Healthy Living Tips', 'healthy-living-tips', '1. Consume Healthy Food\n\nOne of the tips to start a healthy lifestyle is to start eating healthy and nutrient-rich foods, such as fruits, vegetables, whole grains, healthy proteins, and healthy fats, because they are very good for the body.\n\nIn addition, you can also reduce your consumption of added sugar, saturated fat, and excessive salt. As consuming excessive amounts of sugar and salt can have a negative impact on health.\n\nThere are several health problems that can arise due to excessive consumption of both substances, such as obesity, insulin resistance, heart health, dental caries, high blood pressure, fluid retention, kidney disorders. Some studies even suggest that high salt consumption may be linked to an increased risk of autoimmune diseases.\n\nSo, start by choosing fresh foods and avoid processed foods, which often contain added sugar and salt. Limit your consumption of sweets, fizzy drinks and fast foods that tend to be high in sugar.\n\n2. Regular Physical Activity\n\nRegular physical activity has many positive benefits for your physical and mental health. Physical activity not only helps maintain a balanced body weight, but also supports organ, system and mental health functions.\n\nYou can do light physical activities on a regular basis, such as walking, running, cycling, or exercising according to your individual preferences and physical condition. Avoid a sedentary lifestyle and should strive to stay active throughout the day.\n\nTry to schedule consistent exercise, setting a fixed time a day to exercise, whether it\'s morning or evening. Physical activity is an investment for your long-term health. By maintaining regular physical activity, you can reap extensive health benefits for your body and mind.\n\n3. Stress Management\n\nStress management has many positive benefits for your body\'s health and overall well-being. As stress can negatively impact both physical and mental health, by managing stress effectively, one can reap various health benefits.\n\nChronic stress can increase the risk of heart disease. By managing stress, blood pressure and heart rate can be lowered, reducing the risk of cardiovascular complications.\n\nIt is also worth to note that prolonged stress can weaken the immune system, making one more susceptible to infections and diseases. Stress management can boost the body\'s immune response.\n\nYou can start trying to manage stress by using relaxation techniques such as meditation, yoga or deep breathing. Find a hobby or activity that helps release tension and helps you relax.\n\nStress management is not just about avoiding stress, but also about how to respond to and control the stress. By incorporating stress management into one\'s daily routine, one can improve overall health.\n\n4. Get Enough Rest\n\nStarting a healthy lifestyle by getting enough rest is an important step to support physical and mental health. Getting enough sleep every night supports body recovery and brain function.\n\nSome tips for starting a healthy lifestyle with a focus on adequate rest include setting a consistent sleep schedule of the same wake-up and bedtime every day, even on weekends. So, avoid drastic changes in sleep schedule, if possible.\n\nIt is important to maintain consistency in your sleeping habits. Consistency helps the body and brain to get used to healthy sleep patterns. Because starting a healthy lifestyle with adequate rest requires awareness and commitment to maintain sleep quality. Good quality sleep contributes positively to general health, productivity and overall well-being. If you have difficulty falling asleep or have persistent sleep problems, consider consulting to a healthcare professional.\n\n5. Avoid Harmful Habits\n\nAvoiding harmful habits is an important step in adopting a healthy lifestyle. These habits can include consumption of unhealthy food, lack of physical activity, smoking, excessive alcohol consumption, and so on.\n\nSome harmful habits are often done, without realizing that it can have fatal consequences for health and disrupt a healthy lifestyle. Therefore, it is mandatory to avoid harmful habits if you want to have a healthy and quality lifestyle.\n\nFor example, by avoiding excessive alcohol consumption, smoking, and using illegal drugs. If you smoke, consider seeking support and alternative solutions to quit. Limit alcohol consumption and look for alternative activities that do not involve alcohol.\n\nYou should also stay away from risky behaviors such as not wearing a seatbelt while driving or drunk driving.\n\nStarting and maintaining a healthy lifestyle involves small, consistent changes in daily habits. Committing to avoiding harmful habits and implementing positive steps can bring about good changes in your health and well-being.\n\nDon\'t forget to undergo regular medical check-ups to detect health problems early. Keep up with vaccinations and consultations with professionals to maintain physical and mental well-being.\n\nIt is important to remember that a healthy lifestyle is personal and may vary for each individual. Also make sure to identify your health goals. Whether it is losing weight, increasing energy levels, or reducing stress, setting clear goals will help you stay focused and motivated.\n\nStarting a healthy lifestyle is an ongoing journey. Give yourself the opportunity to grow and improve, and remember that small daily changes can have a big impact on your health and well-being.\n\nConsultation with a professional can help you develop a plan that suits your individual health needs and condition.', 'Learn how to maintain a healthy lifestyle...', 'https://cdn.who.int/media/images/default-source/western-pacific-(wpro)/countries/malaysia/checkup.tmb-768v.jpg?sfvrsn=5aa16f38_1', 1, 3, '2025-06-12 11:00:32', '2025-06-12 12:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(4, 'admin', '$2y$10$8vypuTHcAf8r.h685fjwfeGomY/TpIU4rGxwx8BUPt1qjs3kY0MmC', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
