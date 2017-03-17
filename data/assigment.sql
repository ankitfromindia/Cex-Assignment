-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 17, 2017 at 09:12 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci3-fire-starter`
--

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE `captcha` (
  `captcha_id` bigint(13) UNSIGNED NOT NULL,
  `captcha_time` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `captcha`
--

INSERT INTO `captcha` (`captcha_id`, `captcha_time`, `ip_address`, `word`) VALUES
(1, 1489744336, '::1', 'HEWAi');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `session_key` varchar(255) NOT NULL,
  `added` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(256) NOT NULL,
  `title` varchar(128) NOT NULL,
  `message` text NOT NULL,
  `created` datetime NOT NULL,
  `read` datetime DEFAULT NULL,
  `read_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`id`, `name`, `email`, `title`, `message`, `created`, `read`, `read_by`) VALUES
(1, 'John Doe', 'john@doe.com', 'Test Message', 'This is only a test message. Notice that once you\'ve read it, the button changes from blue to grey, indicating that it has been reviewed.', '2013-01-01 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `ip` varchar(20) NOT NULL,
  `attempt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`ip`, `attempt`) VALUES
('::1', '2017-03-17 23:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `billing_email` varchar(100) NOT NULL,
  `billing_mobile` varchar(15) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `billing_city` varchar(50) NOT NULL,
  `billing_state` varchar(50) NOT NULL,
  `billing_pincode` varchar(6) NOT NULL,
  `shipping_email` varchar(100) NOT NULL,
  `shipping_mobile` varchar(15) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `shipping_city` varchar(50) NOT NULL,
  `shipping_state` varchar(50) NOT NULL,
  `shipping_pincode` varchar(6) NOT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `order_dispatched_at` datetime NOT NULL,
  `order_delivered_at` datetime NOT NULL,
  `payment_option` enum('cod','dc','cc','nb') NOT NULL,
  `status` enum('processing','dispatched','delivered') NOT NULL DEFAULT 'processing',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `input_type` enum('input','textarea','radio','dropdown','timezones') CHARACTER SET latin1 NOT NULL,
  `options` text COMMENT 'Use for radio and dropdown: key|value on each line',
  `is_numeric` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'forces numeric keypad on mobile devices',
  `show_editor` enum('0','1') NOT NULL DEFAULT '0',
  `input_size` enum('large','medium','small') DEFAULT NULL,
  `translate` enum('0','1') NOT NULL DEFAULT '0',
  `help_text` varchar(256) DEFAULT NULL,
  `validation` varchar(128) NOT NULL,
  `sort_order` tinyint(3) UNSIGNED NOT NULL,
  `label` varchar(128) NOT NULL,
  `value` text COMMENT 'If translate is 1, just start with your default language',
  `last_update` datetime DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `input_type`, `options`, `is_numeric`, `show_editor`, `input_size`, `translate`, `help_text`, `validation`, `sort_order`, `label`, `value`, `last_update`, `updated_by`) VALUES
(1, 'site_name', 'input', NULL, '0', '0', 'large', '0', NULL, 'required|trim|min_length[3]|max_length[128]', 10, 'Site Name', 'Ankit\'s Store', '2017-03-15 07:25:12', 1),
(2, 'per_page_limit', 'dropdown', '10|10\r\n25|25\r\n50|50\r\n75|75\r\n100|100', '1', '0', 'small', '0', NULL, 'required|trim|numeric', 50, 'Items Per Page', '10', '2017-03-15 07:25:12', 1),
(3, 'meta_keywords', 'input', NULL, '0', '0', 'large', '0', 'Comma-seperated list of site keywords', 'trim', 20, 'Meta Keywords', 'Ankit\'s Store', '2017-03-15 07:25:12', 1),
(4, 'meta_description', 'textarea', NULL, '0', '0', 'large', '0', 'Short description describing your site.', 'trim', 30, 'Meta Description', 'Ankit\'s Store', '2017-03-15 07:25:12', 1),
(5, 'site_email', 'input', NULL, '0', '0', 'medium', '0', 'Email address all emails will be sent from.', 'required|trim|valid_email', 40, 'Site Email', 'er.ankitvishwakarma@gmail.com', '2017-03-15 07:25:12', 1),
(6, 'timezones', 'timezones', NULL, '0', '0', 'medium', '0', NULL, 'required|trim', 60, 'Timezone', 'UP55', '2017-03-15 07:25:12', 1),
(7, 'welcome_message', 'textarea', NULL, '0', '1', 'large', '1', 'Message to display on home page.', 'trim', 70, 'Welcome Message', 'a:7:{s:5:\"dutch\";s:4489:\"<p><img src=\"data:image/png;base64,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\" data-filename=\"ci3-fire-starter.png\" style=\"line-height: 1.42857; width: 63px; float: left;\"></p><p>Deze inhoud wordt <em style=\"color: rgb(41, 82, 24); background-color: rgb(255, 239, 198);\">dynamisch</em> gegenereerd. <strong>Deze tekst kan worden bewerkt in de admin -instellingen.</strong></p><p></p>\";s:7:\"english\";s:4483:\"<p><img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAD8AAABjCAYAAAAsE9hTAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAABZgAAAWYAGbyQRvAAAACXZwQWcAAAA/AAAAYwCuLjAVAAALCUlEQVR42tXdaZBcVRUH8N90iIQlEAwJEJZSYgUUEYiBoAbZZAcBxVIQlwqogDuuuIC4b4iKWoIiUIpooYBioSggilCgRJEQFCGJoCIYWcOShcz44bwmd3r6LdP9umf8f0nS7/ad+7/n3HPP9iYDeoDTrloMz8Bm+DeeOv1lM3vxo7pCo4dzr8JqbIOBbEPGFXpCPpHy/ZiUbYDxtgE9k3y2AUO4C9thi7Em2zfyyQaswmIchfXHk/R7Sj7BYmyMYxk/6t9z8sn5vxZvw4vGywb0S/Lw1+zPT2LaWBPvN/lHsAT74F2YMNbS7yf51ViW/f0kHMTYqn8/yROWH6bgI9h6zJiPAflJyd/nCvVfZ6yk30/yEzG15bP52J+xUf9+kt8AW7Z8NgUfMEbWv5/kt9T+jM/DcfRf+v0kvxM2zVnDidi5r8z7QT6R5osxIWfYNuL6m9hP6fdL8tMy8kU4Ci+lf+rfU/IJibl4bsnwTfB2YRj//8lnGMChht/xeXiZcH/7Iv1+kN82I1UFGwjLv34f1tU78onkjsBospf76tPZ77Xkp+HVo/zOhngt1unx2npDPpHYATq7v/cReb//P/IZpojzO7GD784QRrKnql87+WSxByu/24twCDbqGfNekM8wBceLqk2n2FG5bzB+yCdSPxwv6XK6Kdi1Zd7xSz7D5sJP70bqTewinKTxTT6RztGYU9O022K9cU8+w0y8ucZ5p+qht1eLI5FJvYETsH2N65uYrvHg794y7OEVr9u5q8m7llBLvP76GonDk9ZmfJvYUD32pDb13ADvxvSayf8dy1s+2wjPY6Qm9JV8y9V2cM3E4QZR7EixDM9XQ9KzDsnPEPn3KvH6aPAQfsuwYqdkMw6lO+l3TD6R+nz1XW0pbsai9IPEwP1TlLu7OmYdkU+I74Q3qd8RGcSP8HjO84fEuT+IzqXfjdqvi3fK+m1qxl/wC0aofBNrhMU/Whc5v1GTT6R+kMi49gLfwz0FzyeJNPjuQvv6Qz7DZngvJveA+CL8gFypE8WPSaLVZT86U/1RkW8xci/qAfE1+Ka430cgIThTHDsiOdpR3F/ZvU2I7yLc2F5EhNfhIgqlPoDZyb+3x7Px53TQ0GktXzp95ESjJTAJJ+uNkXsYn8cDJeOmy+L8DJvIT3o8Q2YQWzejMvlE6ofhyB4QhwvwKwqlDi8wPBU+Ac+i7bl/Ktustg7YaCQ/A+/Rm3LSApypoEE5IbafkWFua9NDU80HhUe4PSOlX0o+k/qAcGZ26wHxR0R72t0Vxm4tc2tbUORa/0cckxHtr4XkE3Wfozee3BDOwc/IV/dE6gdgVpshRTyaIfHrGS79Kmq/nghXt6wwdrS4Fl9SrR9/akagXY1/VbsvJBZ+Md4gK6A0NyCXfIuRO7wHxO/FqbivaFAi9SPl+xbLFGOZcMzeba1/UCr5LcTVVncebZW41n5HqXVvruMt2vsla0Rbe1FaawVW4pWy7q+h03LIJ1I/Tm+M3CU4t4x4IvXj8MKcYQ/g9go/c8jajNMzaUM+IT5bZGLrNnK34+N4rGhQQnyOkHreOm7D0pKfub616j5PlnXKU/tJ2Q7V3R76GD4hQtYq6r6+8C22Khjza/lxfxNpCnyiLBQeRj6R+iF648mdK1S+qrq/RjQ35OG/sri/JI29mcTQiXt/50bOwJPV78ndgC9gVUXiO4juzCIH5nqh9m2R3OkzDdfyqdjj6Q9awtXdayb+AE7HvyqO3wAf0t6haWKViPtXlMw1QVR8UzQwt1XyO6i33MRaL+5qKqv7seJaKsIfcRWlKr+J9l0esxoMKzcdL4uQasSNOAtrKhKfgw8afkZbsQbniTNfhu1EvN+KaamEZwsDUyeWC2fm3xXHb4KPKRfATbiUfKkn532e9pmeyY3krB8jaut14oe4gkrqPiDq+geWzLkCX1Pu0hJxyV45zyY2JT8TL6+Z+N34qurWfS+8Q35zchOX46dUqtLuaHjWJ8VAk/z+ohGgLgyJO31hxfHT8VHlFZh78DklTk2i8odpk+jIsLIh7tED1OvGLsT5VFL3hnjZcK+SOVcK+7GASlKfoVibH28Ia1hnrW1QWOJ/FA1K1H1f8bJB2eZflM1bSDyR+hHi6s7D/Y2MeJ119YW4mEq++3TxitmmJeMWiJjgiYrdGNNF8qLIfixtCG+uky7JPFyoxJNLrPubxVVUhPtwingbsxCJ1I+RHwI3cUtDsWqMFktwGZXycXOFuhd5kyvwKVlKu6K67yhsSJHUl+P6huJwcbS4XJZVKcFkEbTMKBn3HXy7jHiCjUVqrOy8LcXChvCq6sCjIlwdqiD1o5W3sVwtUtoryohnUp8g/IQjKqz1WvyrodiHHg3+hFsqjNtehMxFHVVLhH9f6hYn6n6kSMCU1R8flbnGdUZvV2QTt0Um9YnZAot66Z8Qlv1mKp/zFwvnp4oWX4PfN8k/VuELZXhIpJPaGrpE3efhVSVznS+r1FYkPgtfVs1DXS7C6yea5MuqolXwN9xZMmaCiNOLpHMTPouVFQ3cFhnxXasMFjbpGqKg0aiw6CpYJGpuRdgKexY8f0Rca/8omacp9Y2zjTqo4hoXi+rQyuYHDWGousUdIpgpwizFJa/vq5CMzIiviw+LF5GqYIWwCbeytozVEN0Qj1acpB0GRV9cmTu7jfxk5FJ8HasrEG82OJc5MikuEE1Owzo0mpK/owvyTylXeUJNixa3qOjLLQHLqar34V8tiiRPtramNMTvr/p5F+SHjOyPbYe8MUuUWPeE+E74tKzcVAG3Cp/i3nYPm/f8parn2VoxoFoL+P0i8diKy8RtUYZN8RnV37dbLI7GsHPejvzCbBGdYKJilW5iiZG25RH8hFKpD4gg6ICKa1oq8oHX5RGHRmak1uBsxV2PeRiQBUclb0EtNlLCCxW4xC0e3EmqeaRLhEH8ZRFxLZP9WTQADnawAdspz8Q81FxQghuV3zTNYmWVzPIiUXEqJf40+eSKOhtXdkB+RwWeW6LSl1hrfIZkjYPtVD6R+l6yhoIS/AFvxG+qEH+afIIHRRa1SkyeYpbs1Y8S3Cpy+YSnVWZkJ4i3sMuKpteItNXNVYkPI59If4FIGz04CvIbyVzXvHOfSXcQ3xDqOaS8yLgN9ih4PiRuqvmymn9V4sPIt2zAJUIDRhPxFeXIU9wlKrZPyMnkJCq/u/wGiUHhtZ0g6+EbDfER5JMNGMS3skWWdT00sTP2plT6xOaeId63XaegXXye/Cak88S7Pf8ZOH30xNuSTzZgNb4iUstV3Nd1hfoV9uBnG7BGhKK/ke+tTRZ9tu2InyP6/R/shHQh+ZYNOEu8TlLFA9xbtLQU3vnZBjwpHKu8guPmRpaWB0VS8xQ83A1xKpSokt7bffFF5a913IRX4N5Of8txdub3FKmxtAfwQpGk7EriTZR6TMnvr71KpKAulNPumWE3mTfW5XvvWxkeAl+J99dFvBL55gZkm3Cn6Il7n/yqzICwwAfS1Yv/05L1LRJn/N5OJ+uYfLoJwvqfJVLFP5akhRJMFRnY54x2A5Jrrmk4l4tujdvozKrXQj7ZgCFr3ckThefWGhPMFrF3p0WR5touljUj1EmcLmvyiUS3Fu3g8w1PITevtI9gRVUDmEn/PeJ4HYIFdRPvmnzLJgwIH/9Y4Y83G/9WCG/xTCUdWS3k9xYp6TOwZtySb7MJzxI24Sjh+a3CW8VNUVq3T2pvDazuBfHaybdsApF62kdowubCRtw5Xv6Xg/8BZXrc12H898kAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTMtMDgtMTNUMDA6MTM6NDktMDc6MDCUK2T1AAAAJXRFWHRkYXRlOm1vZGlmeQAyMDEzLTA4LTEzVDAwOjEzOjQ5LTA3OjAw5XbcSQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAAUdEVYdFRpdGxlAEdhcyBGbGFtZSBMb2dvWz7WuwAAAABJRU5ErkJggg==\" data-filename=\"ci3-fire-starter.png\" style=\"line-height: 1.42857; width: 63px; float: left;\"></p><p>This content is being generated <em style=\"color: rgb(41, 82, 24); background-color: rgb(255, 239, 198);\">dynamically</em>. <strong>This text is editable in the admin settings.</strong></p>\r\n<p></p>\";s:10:\"indonesian\";s:4476:\"<p><img src=\"data:image/png;base64,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\" data-filename=\"ci3-fire-starter.png\" style=\"line-height: 1.42857; width: 63px; float: left;\"></p><p>Konten ini sedang dihasilkan secara <em style=\"color: rgb(41, 82, 24); background-color: rgb(255, 239, 198);\">dinamis</em>. <strong>Teks ini diedit dalam pengaturan admin.</strong></p><p></p>\";s:7:\"russian\";s:4570:\"<p><img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAD8AAABjCAYAAAAsE9hTAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAABZgAAAWYAGbyQRvAAAACXZwQWcAAAA/AAAAYwCuLjAVAAALCUlEQVR42tXdaZBcVRUH8N90iIQlEAwJEJZSYgUUEYiBoAbZZAcBxVIQlwqogDuuuIC4b4iKWoIiUIpooYBioSggilCgRJEQFCGJoCIYWcOShcz44bwmd3r6LdP9umf8f0nS7/ad+7/n3HPP9iYDeoDTrloMz8Bm+DeeOv1lM3vxo7pCo4dzr8JqbIOBbEPGFXpCPpHy/ZiUbYDxtgE9k3y2AUO4C9thi7Em2zfyyQaswmIchfXHk/R7Sj7BYmyMYxk/6t9z8sn5vxZvw4vGywb0S/Lw1+zPT2LaWBPvN/lHsAT74F2YMNbS7yf51ViW/f0kHMTYqn8/yROWH6bgI9h6zJiPAflJyd/nCvVfZ6yk30/yEzG15bP52J+xUf9+kt8AW7Z8NgUfMEbWv5/kt9T+jM/DcfRf+v0kvxM2zVnDidi5r8z7QT6R5osxIWfYNuL6m9hP6fdL8tMy8kU4Ci+lf+rfU/IJibl4bsnwTfB2YRj//8lnGMChht/xeXiZcH/7Iv1+kN82I1UFGwjLv34f1tU78onkjsBospf76tPZ77Xkp+HVo/zOhngt1unx2npDPpHYATq7v/cReb//P/IZpojzO7GD784QRrKnql87+WSxByu/24twCDbqGfNekM8wBceLqk2n2FG5bzB+yCdSPxwv6XK6Kdi1Zd7xSz7D5sJP70bqTewinKTxTT6RztGYU9O022K9cU8+w0y8ucZ5p+qht1eLI5FJvYETsH2N65uYrvHg794y7OEVr9u5q8m7llBLvP76GonDk9ZmfJvYUD32pDb13ADvxvSayf8dy1s+2wjPY6Qm9JV8y9V2cM3E4QZR7EixDM9XQ9KzDsnPEPn3KvH6aPAQfsuwYqdkMw6lO+l3TD6R+nz1XW0pbsai9IPEwP1TlLu7OmYdkU+I74Q3qd8RGcSP8HjO84fEuT+IzqXfjdqvi3fK+m1qxl/wC0aofBNrhMU/Whc5v1GTT6R+kMi49gLfwz0FzyeJNPjuQvv6Qz7DZngvJveA+CL8gFypE8WPSaLVZT86U/1RkW8xci/qAfE1+Ka430cgIThTHDsiOdpR3F/ZvU2I7yLc2F5EhNfhIgqlPoDZyb+3x7Px53TQ0GktXzp95ESjJTAJJ+uNkXsYn8cDJeOmy+L8DJvIT3o8Q2YQWzejMvlE6ofhyB4QhwvwKwqlDi8wPBU+Ac+i7bl/Ktustg7YaCQ/A+/Rm3LSApypoEE5IbafkWFua9NDU80HhUe4PSOlX0o+k/qAcGZ26wHxR0R72t0Vxm4tc2tbUORa/0cckxHtr4XkE3Wfozee3BDOwc/IV/dE6gdgVpshRTyaIfHrGS79Kmq/nghXt6wwdrS4Fl9SrR9/akagXY1/VbsvJBZ+Md4gK6A0NyCXfIuRO7wHxO/FqbivaFAi9SPl+xbLFGOZcMzeba1/UCr5LcTVVncebZW41n5HqXVvruMt2vsla0Rbe1FaawVW4pWy7q+h03LIJ1I/Tm+M3CU4t4x4IvXj8MKcYQ/g9go/c8jajNMzaUM+IT5bZGLrNnK34+N4rGhQQnyOkHreOm7D0pKfub616j5PlnXKU/tJ2Q7V3R76GD4hQtYq6r6+8C22Khjza/lxfxNpCnyiLBQeRj6R+iF648mdK1S+qrq/RjQ35OG/sri/JI29mcTQiXt/50bOwJPV78ndgC9gVUXiO4juzCIH5nqh9m2R3OkzDdfyqdjj6Q9awtXdayb+AE7HvyqO3wAf0t6haWKViPtXlMw1QVR8UzQwt1XyO6i33MRaL+5qKqv7seJaKsIfcRWlKr+J9l0esxoMKzcdL4uQasSNOAtrKhKfgw8afkZbsQbniTNfhu1EvN+KaamEZwsDUyeWC2fm3xXHb4KPKRfATbiUfKkn532e9pmeyY3krB8jaut14oe4gkrqPiDq+geWzLkCX1Pu0hJxyV45zyY2JT8TL6+Z+N34qurWfS+8Q35zchOX46dUqtLuaHjWJ8VAk/z+ohGgLgyJO31hxfHT8VHlFZh78DklTk2i8odpk+jIsLIh7tED1OvGLsT5VFL3hnjZcK+SOVcK+7GASlKfoVibH28Ia1hnrW1QWOJ/FA1K1H1f8bJB2eZflM1bSDyR+hHi6s7D/Y2MeJ119YW4mEq++3TxitmmJeMWiJjgiYrdGNNF8qLIfixtCG+uky7JPFyoxJNLrPubxVVUhPtwingbsxCJ1I+RHwI3cUtDsWqMFktwGZXycXOFuhd5kyvwKVlKu6K67yhsSJHUl+P6huJwcbS4XJZVKcFkEbTMKBn3HXy7jHiCjUVqrOy8LcXChvCq6sCjIlwdqiD1o5W3sVwtUtoryohnUp8g/IQjKqz1WvyrodiHHg3+hFsqjNtehMxFHVVLhH9f6hYn6n6kSMCU1R8flbnGdUZvV2QTt0Um9YnZAot66Z8Qlv1mKp/zFwvnp4oWX4PfN8k/VuELZXhIpJPaGrpE3efhVSVznS+r1FYkPgtfVs1DXS7C6yea5MuqolXwN9xZMmaCiNOLpHMTPouVFQ3cFhnxXasMFjbpGqKg0aiw6CpYJGpuRdgKexY8f0Rca/8omacp9Y2zjTqo4hoXi+rQyuYHDWGousUdIpgpwizFJa/vq5CMzIiviw+LF5GqYIWwCbeytozVEN0Qj1acpB0GRV9cmTu7jfxk5FJ8HasrEG82OJc5MikuEE1Owzo0mpK/owvyTylXeUJNixa3qOjLLQHLqar34V8tiiRPtramNMTvr/p5F+SHjOyPbYe8MUuUWPeE+E74tKzcVAG3Cp/i3nYPm/f8parn2VoxoFoL+P0i8diKy8RtUYZN8RnV37dbLI7GsHPejvzCbBGdYKJilW5iiZG25RH8hFKpD4gg6ICKa1oq8oHX5RGHRmak1uBsxV2PeRiQBUclb0EtNlLCCxW4xC0e3EmqeaRLhEH8ZRFxLZP9WTQADnawAdspz8Q81FxQghuV3zTNYmWVzPIiUXEqJf40+eSKOhtXdkB+RwWeW6LSl1hrfIZkjYPtVD6R+l6yhoIS/AFvxG+qEH+afIIHRRa1SkyeYpbs1Y8S3Cpy+YSnVWZkJ4i3sMuKpteItNXNVYkPI59If4FIGz04CvIbyVzXvHOfSXcQ3xDqOaS8yLgN9ih4PiRuqvmymn9V4sPIt2zAJUIDRhPxFeXIU9wlKrZPyMnkJCq/u/wGiUHhtZ0g6+EbDfER5JMNGMS3skWWdT00sTP2plT6xOaeId63XaegXXye/Cak88S7Pf8ZOH30xNuSTzZgNb4iUstV3Nd1hfoV9uBnG7BGhKK/ke+tTRZ9tu2InyP6/R/shHQh+ZYNOEu8TlLFA9xbtLQU3vnZBjwpHKu8guPmRpaWB0VS8xQ83A1xKpSokt7bffFF5a913IRX4N5Of8txdub3FKmxtAfwQpGk7EriTZR6TMnvr71KpKAulNPumWE3mTfW5XvvWxkeAl+J99dFvBL55gZkm3Cn6Il7n/yqzICwwAfS1Yv/05L1LRJn/N5OJ+uYfLoJwvqfJVLFP5akhRJMFRnY54x2A5Jrrmk4l4tujdvozKrXQj7ZgCFr3ckThefWGhPMFrF3p0WR5touljUj1EmcLmvyiUS3Fu3g8w1PITevtI9gRVUDmEn/PeJ4HYIFdRPvmnzLJgwIH/9Y4Y83G/9WCG/xTCUdWS3k9xYp6TOwZtySb7MJzxI24Sjh+a3CW8VNUVq3T2pvDazuBfHaybdsApF62kdowubCRtw5Xv6Xg/8BZXrc12H898kAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTMtMDgtMTNUMDA6MTM6NDktMDc6MDCUK2T1AAAAJXRFWHRkYXRlOm1vZGlmeQAyMDEzLTA4LTEzVDAwOjEzOjQ5LTA3OjAw5XbcSQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAAUdEVYdFRpdGxlAEdhcyBGbGFtZSBMb2dvWz7WuwAAAABJRU5ErkJggg==\" data-filename=\"ci3-fire-starter.png\" style=\"line-height: 1.42857; width: 63px; float: left;\"></p><p>Это содержание генерируется <em style=\"color: rgb(41, 82, 24); background-color: rgb(255, 239, 198);\">динамически</em>. <strong>Этот текст можно изменить в настройках администратора.</strong></p><p></p>\";s:18:\"simplified-chinese\";s:4376:\"<p><img src=\"data:image/png;base64,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\" data-filename=\"ci3-fire-starter.png\" style=\"line-height: 1.42857; width: 63px; float: left;\"></p><p>正在动态生成此内容. <strong>该文本可编辑在管理设置.</strong></p><p></p>\";s:7:\"spanish\";s:4494:\"<p><img src=\"data:image/png;base64,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\" data-filename=\"ci3-fire-starter.png\" style=\"line-height: 1.42857; width: 63px; float: left;\"></p><p>Este contenido se genera <em style=\"color: rgb(41, 82, 24); background-color: rgb(255, 239, 198);\">dinámicamente</em>. <strong>Este texto es editable en la configuración de administrador.</strong></p><p></p>\";s:7:\"turkish\";s:4489:\"<p><img src=\"data:image/png;base64,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\" data-filename=\"ci3-fire-starter.png\" style=\"line-height: 1.42857; width: 63px; float: left;\"></p><p>Bu içerik <em style=\"color: rgb(41, 82, 24); background-color: rgb(255, 239, 198);\">dinamik</em> olarak oluşturulan ediliyor. <strong>Bu metin yönetici ayarlarında düzenlenebilir.</strong></p><p></p>\";}', '2017-03-15 07:25:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(256) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `language` varchar(64) DEFAULT NULL,
  `is_admin` enum('0','1') NOT NULL DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `validation_code` varchar(50) DEFAULT NULL COMMENT 'Temporary code for opt-in registration',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `first_name`, `last_name`, `email`, `mobile`, `address`, `city`, `state`, `pincode`, `language`, `is_admin`, `status`, `deleted`, `validation_code`, `created`, `updated`) VALUES
(1, 'admin', 'ce516f215aa468c376736c9013e8b663f7b3c06226a87739bc6b32882f9278349a721ea725a156eecf9e3c1868904a77e4d42c783e0287a0909a8bbb97e1525f', '66cb0ab1d9efe250b46e28ecb45eb33b3609f1efda37547409a113a2b84c3f94b6a0e738acc391e2dfa718676aa55adead05fcb12d2e32aee379e190511a3252', 'Site', 'Administrator', 'admin@admin.com', '', '', '', '', '', 'english', '1', '1', '0', NULL, '2013-01-01 00:00:00', '2016-02-26 21:46:43'),
(3, 'ankit', '6b685e5f603f2dedb27da4b1efc3eddd1a7de7bf2918e2dcd5430bfe41aec05d7bc045bbbb47406d8b23a29d4318b8a8c3658cd5d0a171a5548f90507fbb46d2', '1652312167e1abe7bc200c013886763ee09a2bc94382ecc2e5a46f1a5beb526cfc5542cb7410e2affdcb5f2ec6e5a0b6862c87c2cc7142ac64eead8b00838c29', 'ankit', 'vishwakarma', 'ankit@gmail.com', '', '', '', '', '', 'english', '0', '1', '0', NULL, '2017-03-16 18:29:56', '2017-03-16 18:49:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `captcha`
--
ALTER TABLE `captcha`
  ADD PRIMARY KEY (`captcha_id`),
  ADD KEY `word` (`word`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `title` (`title`),
  ADD KEY `created` (`created`),
  ADD KEY `read` (`read`),
  ADD KEY `read_by` (`read_by`),
  ADD KEY `email` (`email`(78));

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD KEY `ip` (`ip`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `updated_by` (`updated_by`);

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
-- AUTO_INCREMENT for table `captcha`
--
ALTER TABLE `captcha`
  MODIFY `captcha_id` bigint(13) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
