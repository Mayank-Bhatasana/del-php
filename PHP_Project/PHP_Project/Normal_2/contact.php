<?php
include('db_connect.php');
ob_start();
session_start();

// Initialize variables
$errors = [];
$form_data = [
    'name' => '',
    'phone' => '',
    'email' => '',
    'message' => ''
];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $form_data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $form_data['phone'] = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $form_data['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $form_data['message'] = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Validate name (2-20 alphabets and spaces)
    if (empty($form_data['name'])) {
        $errors['name'] = "Name field is required";
    } elseif (!preg_match('/^[a-zA-Z ]{2,20}$/', $form_data['name'])) {
        $errors['name'] = "Name must contain only alphabets (2-20 characters)";
    }

    // Validate email
    if (empty($form_data['email'])) {
        $errors['email'] = "Email field cannot be empty";
    } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid Email format";
    }

    // Validate phone (10 digits)
    if (empty($form_data['phone'])) {
        $errors['phone'] = "Phone number field cannot be empty";
    } elseif (!preg_match('/^[0-9]{10}$/', $form_data['phone'])) {
        $errors['phone'] = "Invalid Phone Number (10 digits required)";
    }

    // Validate message
    if (empty($form_data['message'])) {
        $errors['message'] = "Message cannot be empty";
    }

    // If no errors, save to database
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO contacts (name, phone, email, message, created_at) 
                                   VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssss", 
                $form_data['name'],
                $form_data['phone'],
                $form_data['email'],
                $form_data['message']
            );
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Your message has been sent successfully!";
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            } else {
                $errors['database'] = "Error saving your message. Please try again.";
            }
        } catch (Exception $e) {
            $errors['database'] = "Database error: ".$e->getMessage();
        }
    }
}

include 'header.php';
?>

<!-- Display success message if exists -->
<?php if (!empty($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success_message']); ?>
        <?php unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>

<!-- Display database error if exists -->
<?php if (!empty($errors['database'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($errors['database']); ?>
    </div>
<?php endif; ?>

<!-- Contact Section -->
<section class="contact">
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <h3>Get in Touch</h3>
        
        <!-- Name Field -->
        <span>Enter Name</span>
        <input type="text" class="box <?= !empty($errors['name']) ? 'error-field' : '' ?>" 
               name="name" value="<?= htmlspecialchars($form_data['name']); ?>" 
               placeholder="ex. Ved Brahmani" required>
        <?php if (!empty($errors['name'])): ?>
            <span class="error-message"><?= htmlspecialchars($errors['name']); ?></span>
        <?php endif; ?>

        <!-- Phone Field -->
        <span>Enter Phone Number</span>
        <input type="text" class="box <?= !empty($errors['phone']) ? 'error-field' : '' ?>" 
               name="phone" value="<?= htmlspecialchars($form_data['phone']); ?>" 
               placeholder="+91 9824219058" required>
        <?php if (!empty($errors['phone'])): ?>
            <span class="error-message"><?= htmlspecialchars($errors['phone']); ?></span>
        <?php endif; ?>

        <!-- Email Field -->
        <span>Enter Email</span>
        <input type="email" class="box <?= !empty($errors['email']) ? 'error-field' : '' ?>" 
               name="email" value="<?= htmlspecialchars($form_data['email']); ?>" 
               placeholder="ex. 23020201025@darshan.ac.in" required>
        <?php if (!empty($errors['email'])): ?>
            <span class="error-message"><?= htmlspecialchars($errors['email']); ?></span>
        <?php endif; ?>

        <!-- Message Field -->
        <span>Enter Your Message</span>
        <textarea name="message" cols="30" rows="10" 
                  class="box <?= !empty($errors['message']) ? 'error-field' : '' ?>" 
                  required><?= htmlspecialchars($form_data['message']); ?></textarea>
        <?php if (!empty($errors['message'])): ?>
            <span class="error-message"><?= htmlspecialchars($errors['message']); ?></span>
        <?php endif; ?>

        <input type="submit" value="Send Message" class="btn">
    </form>
</section>

<style>
    .error-field {
        border: 2px solid #ff0000 !important;
    }
    .error-message {
        color: #ff0000;
        font-size: 14px;
        display: block;
        margin-top: 5px;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }
</style>

<?php
include 'footer.php';
ob_end_flush();
?>