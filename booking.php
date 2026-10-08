<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $service = $_POST["service"];
    $booking_date = $_POST["booking_date"];
    $user_message = $_POST["message"];

    $sql = "INSERT INTO bookings 
            (name, phone, email, service, booking_date, message)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param(
            "ssssss",
            $name,
            $phone,
            $email,
            $service,
            $booking_date,
            $user_message
        );

        if ($stmt->execute()) {
            $message = "Booking submitted successfully! 🎉";
        } else {
            $message = "Error submitting booking.";
        }

        $stmt->close();
    } else {
        $message = "Database error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book Embrace Media</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 40px;
        }

        .booking-container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        h1 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        textarea {
            height: 120px;
        }

        button {
            width: 100%;
            padding: 14px;
            background: black;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #333;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="booking-container">

    <h1>Book Embrace Media</h1>

    <?php if ($message != ""): ?>
        <div class="success">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label>Your Name</label>
        <input type="text" name="name" placeholder="Enter your name" required>

        <label>Phone Number</label>
        <input type="text" name="phone" placeholder="Enter your phone number" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email">

        <label>Choose Service</label>
        <select name="service" required>
            <option value="">-- Select a service --</option>
            <option value="Poster Design">Poster Design</option>
            <option value="Website Design">Website Design</option>
            <option value="Logo Design">Logo Design</option>
            <option value="Photography">Photography</option>
            <option value="Videography">Videography</option>
        </select>

        <label>Booking Date</label>
        <input type="date" name="booking_date" required>

        <label>Message</label>
        <textarea name="message" placeholder="Tell us what you need..."></textarea>

        <button type="submit">Book Now</button>

    </form>

</div>

</body>
</html>