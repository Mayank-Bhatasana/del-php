<?php
include('db_connect.php');
ob_start();
session_start();
?>

<?php
include 'header.php';
?>

<br><br>

<table>

<tr>
		<td style="padding-left: 50px;"><img src="img/product-1.png" height="500" width="500"></td>
        
		<td style="padding-left: 50px;">
		
			<h1 style="color: #5e473e; font-size: large;">Details</h1><br>


			<h1 style="color: #5e473e; font-size: large;">Morden Chair</h1></li>
			<h3 style="color: #b58d7e;">Brand : Urban Furniture</h3><br><br>


            <h3 style="color: #5e473e; font-size: large;">Details : </h3>

<h2>Our Chair's are of handmade.</h2>
<h2>Our Chair's are made of high quality wood and fabric.</h2>
<h2>Our Chair's are designed to be comfortable and durable.</h2>
<h2>Our Chair's are perfect for home and office use.</h2>
<h2>Our Chair's are designed to be easy to move around your home.</h2>



<br><br>


            <h1 style="color: #5e473e; font-size: large;"> Rating : </h1><br>
			    <div class="star" style="color: gold; font-size: large;">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div><br><br><br>
                <h1 style="color: #5e473e; font-size: large;"> Review : </h1><br>
                
                <style>
                    .review-container {
                        border: 1px solid #ccc;
                        padding: 10px;
                        margin-bottom: 10px;
                        font-family: sans-serif; /* Use a suitable font */
                    }
                
                    .review-header {
                        display: flex;
                        align-items: center;
                        margin-bottom: 5px;
                    }
                
                    .author {
                        font-weight: bold;
                        margin-right: 10px;
                    }
                
                    .rating {
                        margin-right: 10px;
                    }
                
                    .star {
                        color: gold; /* Or any color you prefer for stars */
                        font-size: 1.2em; /* Adjust star size as needed */
                    }
                
                    .review-title {
                        margin: 0;
                    }
                
                    .location {
                        font-size: smaller;
                        color: #777;
                    }
                
                    .review-details {
                        margin-bottom: 5px;
                    }
                
                    .detail-item {
                        margin-right: 10px;
                    }
                
                    .verified {
                        color: green;
                        font-weight: bold;
                    }
                
                    .review-content {
                        margin-bottom: 10px;
                    }
                
                    .review-footer {
                        display: flex;
                        align-items: center;
                    }
                
                    .helpful-count {
                        margin-right: 10px;
                    }
                
                    .helpful-button, .report-button {
                        /* Add your button styles here */
                        padding: 5px 10px;
                        border: none;
                        background-color: #eee;
                        cursor: pointer;
                        margin-right: 5px; /* Space between buttons */
                    }
                </style>

                <div class="review-container">
                    <div class="review-header">
                    <i class="fa-solid fa-user" style="font-size: small;"><span class="author" style="font-size: small;">        John Deo</span></i><br>
                        <div class="rating" style="font-size: small;">
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                        </div>
                        <h3 class="review-title" style="font-size: small;">Too good.</h3>
                    </div>

                    <div class="review-details" style="font-size: small;">
                        <span class="detail-item">Size: Standard</span>
                        <span class="detail-item">Colour: Black</span>
                        <span class="detail-item verified">Verified Purchase</span>
                    </div>

                    <div class="review-content" style="font-size: small;">
                        <p>A very well compact rigid chair, truly designed in foreign.</p>
                    </div>
                </div>

                <div class="review-container">
                    <div class="review-header">
                    <i class="fa-solid fa-user" style="font-size: small;"><span class="author" style="font-size: small;">        John Deo</span></i><br>
                        <div class="rating" style="font-size: small;">
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                        </div>
                        <h3 class="review-title" style="font-size: small;">Perfect chairs.</h3>
                    </div>

                    <div class="review-details" style="font-size: small;">
                        <span class="detail-item">Size: Standard</span>
                        <span class="detail-item">Colour: Black</span>
                        <span class="detail-item verified">Verified Purchase</span>
                    </div>

                    <div class="review-content" style="font-size: small;">
                        <p>Very comfortable chairs. Extremely easy to assemble. <br> Looks great in my living room. Great size and comfort level. <br> I'm not small man and it seems very sturdy</p>
                    </div>
                </div>



                <td style="padding-left: 50px;">
                <style>
                    .card {
                        border: 1px solid #ddd;
                        border-radius: 10px;
                        padding: 15px;
                        width: 300px;
                        box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
                    }
                    .price {
                        font-size: 24px;
                        font-weight: bold;
                    }
                    .delivery {
                        color: green;
                        font-size: 14px;
                    }
                    .location {
                        color: #0073e6;
                        font-size: 14px;
                        cursor: pointer;
                    }
                    .stock {
                        color: green;
                        font-weight: bold;
                    }
                    .buttons {
                        margin-top: 10px;
                    }
                    .btn {
                        width: 100%;
                        padding: 10px;
                        border: none;
                        font-size: 16px;
                        cursor: pointer;
                        border-radius: 5px;
                        margin-bottom: 5px;
                    }
                    .add-to-cart {
                        background-color: #ffd814;
                    }
                    .buy-now {
                        background-color: #ff9900;
                    }
                    .wishlist {
                        border: 1px solid #ddd;
                        background-color: #ff9900; 
                    }
                </style>
                <div class="card">
                    <div class="price">₹140.00</div>
                    <div class="location">Delivering to Rajkot 360020 - Update location</div>
                    <br>
                    <div class="stock">In stock</div>
                    <div style="font-size: small;">Ships from <b>Urban Furniture</b></div>
                    <div style="font-size: small;">Sold by <b>Urban Furniture</b></div>
                    <br>
                    <label for="quantity" style="font-size: small;">Quantity:</label>
                    <select id="quantity">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                    <div class="buttons">
                        <a href="cart.php"><button class="btn add-to-cart">Add to Cart</button></a>
                        <a href="buynow.php"><button class="btn buy-now">Buy Now</button></a>
                        <a href="wish.php"><button class="btn wishlist">Add to Wish List</button></a>
                    </div>
                </div>
                </td>
    
    
    
    
    
        
        </td>

</tr>

</table>


<?php
include 'footer.php';
?> 