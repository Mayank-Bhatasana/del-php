<?php
include('db_connect.php');
ob_start();
session_start();
?>
<?php
include 'header.php';
?>

<br><br>

    <!-- <style>

        .delivery-address {
            border: 1px solid #ccc; /* Add a light border */
            padding: 20px; /* Add padding inside the box */
            border-radius: 5px; /* Round the corners */
            max-width: 400px; /* Set a maximum width for responsiveness */
            margin: 0 auto; /* Center the box horizontally */
        }

        .delivery-address h1 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .change-link {
            float: right;
            color: #007bff; /* Blue link color */
            text-decoration: none;
        }

        .address-details {
            margin-bottom: 15px;
        }

        .address-details p {
            margin: 5px 0;
        }

        .add-instructions {
            color: #007bff; /* Blue link color */
            text-decoration: none;
        }
    </style>

    <div class="delivery-address">
        <h1>1 Delivery address</h1>
        <a href="#" class="change-link">Change</a>

        <div class="address-details">
            <p>Pranshu Babariya</p>
            <p>R.K UNIVERSITY</p>
            <p>Bhavnagar Highway, Tramba, Gujarat 360020</p>
            <p>RAJKOT, GUJARAT 360020</p>
        </div>

        <a href="#" class="add-instructions">Add delivery instructions</a>
    </div> -->


    <style>

        .payment-container {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            max-width: 500px;
            margin: 0 auto;
        }

        .balance {
            margin-bottom: 20px;
        }

        .balance label {
            display: inline-block;
            vertical-align: middle; /* Align checkbox and label */
        }

        .balance-info {
            display: inline-block;
            margin-left: 10px;
        }

        .balance-low {
            color: #888;
            font-size: smaller;
        }

        .add-money {
            color: #007bff;
            text-decoration: none;
        }

        .apply-code {
            margin-bottom: 20px;
        }

        .apply-code input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .apply-code button {
            padding: 8px 16px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
        }

        .payment-method {
            margin-bottom: 20px;
        }

        .payment-method label {
            display: block; /* Each option on a new line */
            margin-bottom: 10px;
        }

        .payment-method img {
            vertical-align: middle;
            margin-left: 5px;
        }

        .net-banking select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .cod-info {
            color: #888;
            font-size: smaller;
        }
    </style>

<div class="payment-container">

        <div class="payment-method">
            <p style="font-size: x-large;"><strong>Payment Methods</strong></p><br>
            <p>_______________________________________________________________________________</p><br><br>
         
            <label>
           
    <label>
        <input type="radio" name="payment" id="cardRadio"> <span style="font-size: large;">Credit or debit card</span>
        <br>
        <img src="img/visa.png" alt="Visa" width="50px">
        <img src="img/mastercard.png" alt="Mastercard" width="50px">
        <img src="img/rupay.png" alt="RuPay" width="50px">
        <img src="img/phonepay.jpg" alt="Phonepay" width="50px">
        <img src="img/googlepay.jpg" alt="Googlepay" width="50px">
    </label><br>
    











            <label>
                <input type="radio" name="payment"><span style="font-size: large;"  style="padding-left: 50px;">Net Banking</span>
                <br><br><select>
                    <option value="" selected>Choose an Option</option>
                    <option value="">Axis Bank</option>
                    <option value="">HDFC Bank</option>
                    <option value="">ICICI Bank</option>
                    <option value="">Kotak Bank</option>
                    <option value="">State Bank of India</option>
                </select>
            </label><br><br>

            <label>
                <input type="radio" name="payment" id="upiRadio"> <span style="font-size: large;">Other UPI Apps</span>
            </label>
            <style>
                .upi-container {
                    border: 1px solid #ccc;
                    padding: 20px;
                    border-radius: 5px;
                    max-width: 400px;
                    margin: 20px auto;
                    background-color: #f9f9f9; /* Light background color */
                    display: none; /* Initially hidden */
                }
            
                .upi-container label {
                    display: block;
                    margin-bottom: 10px;
                    font-weight: bold;
                }
            
                .upi-container input[type="text"] {
                    width: calc(100% - 80px); /* Adjust width for button */
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                    margin-bottom: 10px;
                }
            
                .upi-container button {
                    padding: 10px 20px;
                    background-color: #fff8dc; /* Light yellow/beige color */
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    cursor: pointer;
                    margin-left: 10px;
                }
            
                .upi-container .upi-info {
                    font-size: smaller;
                    color: #777;
                }
            </style>

    <div class="upi-container" id="upiContainer">
        <label for="upiId" style="font-size: medium;">Other UPI Apps</label>
        <p style="font-size: medium;">Please enter your UPI ID</p>
        <input type="text" id="upiId" placeholder="Enter UPI ID" style="font-size: medium;">
        <button id="verifyButton" style="font-size: medium;">Verify</button>
        <p class="upi-info" style="font-size: medium;">The UPI ID is in the format of name/phone number@bankname</p>
        <p id="verificationResult" style="font-size: medium;"></p>
    </div>


    <script>
        document.getElementById('verifyButton').addEventListener('click', function() {
            var upiId = document.getElementById('upiId').value;
            var verificationResult = document.getElementById('verificationResult');

            // Simple regex to check UPI ID format (name/phone@bank)
            var upiRegex = /^[a-zA-Z0-9.\-_]{2,256}@[a-zA-Z]{2,64}$/;

            if (upiRegex.test(upiId)) {
                verificationResult.textContent = 'UPI ID is valid.';
                verificationResult.style.color = 'green';
            } else {
                verificationResult.textContent = 'UPI ID is invalid. Please enter a valid UPI ID.';
                verificationResult.style.color = 'red';
            }
        });
        document.getElementById('upiRadio').addEventListener('change', function() {
            var upiContainer = document.getElementById('upiContainer');
            if (this.checked) {
                upiContainer.style.display = 'block';
            } else {
                upiContainer.style.display = 'none';
            }
        });
    </script><br><br>









            <label>
                <input type="radio" name="payment" id="emiRadio"> <span style="font-size: large;">EMI</span>
            </label><br><br>

            <style>
                .emi-container {
                    border: 1px solid #ccc;
                    padding: 20px;
                    border-radius: 5px;
                    max-width: 500px;
                    margin: 20px auto;
                    background-color: #f9f9f9;
                    display: none; /* Initially hidden */
                }
            
                .emi-container label {
                    display: block;
                    margin-bottom: 10px;
                    font-weight: bold;
                }
            
                .emi-options {
                    display: flex;
                    align-items: center; /* Align items vertically */
                    margin-bottom: 10px;
                }
            
                .emi-options select {
                    padding: 8px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    flex-grow: 1; /* Allow select to take up available space */
                    margin-right: 10px; /* Space between select and images */
                }
            
                .emi-options img {
                    width: 40px; /* Adjust image size as needed */
                    height: auto;
                    margin-right: 5px;
                }
            
                .save-card {
                    display: flex;
                    align-items: center;
                }
            
                .save-card input[type="checkbox"] {
                    margin-right: 5px;
                }
            
                .save-card span {
                    color: #777;
                    font-size: smaller;
                }
            </style>

    <div class="emi-container" id="emiContainer">
        <label for="emiSelect" style="font-size: large;">EMI</label>

        <div class="emi-options">
            <select id="emiSelect">
                <option value="">Add a new card</option>
            </select>
            <div>
                <img src="img/visa.png" alt="Visa" width="50px">
                <img src="img/mastercard.png" alt="MasterCard" width="50px">
                <img src="img/rupay.png" alt="Rupay" width="50px">
                <img src="img/rupay.png" alt="RuPay" width="50px">
                <img src="img/phonepay.jpg" alt="Phonepay" width="50px">
                <img src="img/googlepay.jpg" alt="Googlepay" width="50px">
            </div>
        </div>

        <style>
            .save-card {
                display: flex;
                align-items: center; /* Vertically align items */
                font-family: Arial, sans-serif; /* Use a common font */
            }

            .save-card input[type="checkbox"] {
                margin-right: 8px; /* Space between checkbox and image */
                appearance: none; /* Remove default checkbox styling */
                width: 18px; /* Adjust checkbox size */
                height: 18px;
                border: 1px solid #ccc;
                border-radius: 3px;
                cursor: pointer;
                position: relative; /* For custom checkmark */
            }

            /* Custom checkmark */
            .save-card input[type="checkbox"]:checked::before {
                content: '\2713'; /* Checkmark character */
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-size: 14px;
                color: #007185; /* Amazon's blue color */
            }

            .save-card img {
                width: 30px; /* Adjust image size as needed */
                height: auto;
                margin-right: 8px; /* Space between image and text */
                border: 1px solid #ccc; /* Add border to image */
                padding: 2px; /* Add padding to image */
            }

            .save-card span {
                color: #555; /* Slightly darker text color */
                font-size: 14px;
            }

            .save-card a {
                color: #007185; /* Amazon's blue link color */
                text-decoration: none;
            }
        </style>

        <div class="save-card">
            <input type="checkbox" id="saveCard">
            <img src="img/cc.avif" alt="Card">
            <span><a href="#" id="openPopupButton">Save Card</a> > Amazon accepts all major credit & cards</span>
        </div>
    </div>

    <style>
        /* Basic styling for overlay and popup */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .popup {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            max-width: 500px; /* Adjust as needed */
            position: relative; /* For close button positioning */
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            border: none;
            background: none;
        }

        /* Form specific styles */
        .popup label {
            display: block;
            margin-bottom: 5px;
        }

        .popup input[type="text"],
        .popup select {
            width: calc(100% - 10px); /* Adjust for padding and border */
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .card-logos {
            display: flex;
            margin-bottom: 10px;
        }

        .card-logos img {
            width: 40px;
            height: auto;
            margin-right: 5px;
            border: 1px solid #ccc;
            padding: 2px;
        }

        .popup .buttons {
            display: flex;
            justify-content: flex-end; /* Align buttons to the right */
        }

        .popup button {
            padding: 10px 20px;
            margin-left: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .popup button.cancel {
            background-color: #eee;
        }

        .popup button.save {
            background-color: #f0c14b; /* Example - Amazon-like yellow */
            font-weight: bold;
        }

        /* Initially hide the overlay */
        .overlay {
            display: none;
        }
    </style>

    <div class="overlay" id="saveCardOverlay">
        <div class="popup">
            <button class="close-button" onclick="closePopup()">&times;</button>

            <h2>Save Card</h2>

            <label for="cardNumber">Card number</label>
            <input type="text" id="cardNumber" placeholder="0000-0000-0000-0000">
            <p style="font-size: smaller; color: #777;">Please ensure that you enable your card for online payments from your bank's app.</p>

            <label for="nickname">Nickname</label>
            <input type="text" id="nickname" value="Akshar Khunt">

            <label for="expiryMonth">Expiry date</label>
            <select id="expiryMonth">
                <option value="01">01</option>
                <!-- Add more months as needed -->
            </select>
            <select id="expiryYear">
                <option value="2025">2025</option>
                <!-- Add more years as needed -->
            </select>

            <div class="card-logos">
                <img src="img/visa.png" alt="Visa">
                <img src="img/mastercard.png" alt="Mastercard">
                <img src="img/googlepay.jpg" alt="Googlepay">
                <img src="img/phonepay.jpg" alt="Phonepay">
                <img src="img/rupay.png" alt="RuPay">
            </div>

            <div class="buttons">
                <button class="cancel" onclick="closePopup()">Cancel</button>
                <button class="save" id="saveCardButton">Save Card</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('saveCardButton').addEventListener('click', function() {
            var cardNumber = document.getElementById('cardNumber').value;
            var nickname = document.getElementById('nickname').value;
            var expiryMonth = document.getElementById('expiryMonth').value;
            var expiryYear = document.getElementById('expiryYear').value;

            var cardNumberRegex = /^[0-9]{16}$/;

            if (!cardNumberRegex.test(cardNumber)) {
                alert('Please enter a valid 16-digit card number.');
                return;
            }

            if (nickname.trim() === '') {
                alert('Please enter a nickname for the card.');
                return;
            }

            if (expiryMonth === '' || expiryYear === '') {
                alert('Please select a valid expiry date.');
                return;
            }

            // If all validations pass, close the popup
            closePopup();
            alert('Card saved successfully!');
        });

        document.getElementById('emiRadio').addEventListener('change', function() {
            var emiContainer = document.getElementById('emiContainer');
            if (this.checked) {
                emiContainer.style.display = 'block';
            } else {
                emiContainer.style.display = 'none';
            }
        });
    </script>

    <script>
        const openPopupButton = document.getElementById('openPopupButton');
        const saveCardOverlay = document.getElementById('saveCardOverlay');

        openPopupButton.addEventListener('click', () => {
            saveCardOverlay.style.display = 'flex';
        });

        function closePopup() {
            saveCardOverlay.style.display = 'none';
        }
    </script>

    <script>
        const paymentRadios = document.querySelectorAll('input[name="payment"]');
        const upiContainer = document.getElementById('upiContainer');
        const emiContainer = document.getElementById('emiContainer');

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.id === 'upiRadio') {
                    upiContainer.style.display = 'block';
                    emiContainer.style.display = 'none';
                } else if (this.id === 'emiRadio') {
                    emiContainer.style.display = 'block';
                    upiContainer.style.display = 'none';
                } else {
                    upiContainer.style.display = 'none';
                    emiContainer.style.display = 'none';
                }
            });
        });
    </script>












            <label>
                <input type="radio" name="payment"> <span style="font-size: large; color:#888">Cash on Delivery/Pay on Delivery</span>
                <p class="cod-info"><span style="font-size: large;">Not available for a few or all items.</span></p>
            </label>
    </div>
    <p>_______________________________________________________________________________</p><br><br>
        <div style="text-align: center;">
            <button style="background-color: gold; font-size: medium;"> Use this payment method </button>
        </div>
    </div>


        









    <?php
include 'footer.php';
?>