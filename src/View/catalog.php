<div class="container">
    <h3>Catalog</h3>
        <div class="card-deck">
            <?php foreach ($data as $product): ?>
                <a href="#">
                    <form action="/product" method="POST">
                        <button type="submit" class="button" role="button"> <img class="card-img-top" src="<?php echo $product->getImage();?>" alt="Card image"></button>
                            <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>" id="product_id" required>
                                </form>
                                    <form action="/catalog" method="POST">
                                    <div class="card-body">
                                        <p class="card-text text-muted"><?php echo $product->getName(); ?></p>
                                        <div class="card-footer">
                                            <?php echo $product->getPrice(); ?>
                                             </div>
                                              </div>
                                                 <label style="color: red;">
                                                      <?php if (!empty($errors['product_id'])) {
                                                     print_r($errors['product_id']);
                                                     }?>
                                                     </label>
                                                     <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>" id="product_id" required>
                                                     <label for="amount"><b>Amount</b></label>
                                                    <label style="color: red">
                                                <?php if (!empty($errors['amount'])) {
                                            print_r($errors['amount']);
                                         }?>
                                        </label>
                                    <input type="text" placeholder="Enter amount" name="amount" id="amount" required>
                                  <button type="submit" class="registerbtn">Добавить</button>
                                </form>
                             </a>
                       </div>
                    <?php endforeach; ?>
              <!--   <div class="review">
             <a href="./review.php" class="btn">Оставить отзыв</a>
        </div>-->
    </div>
</div>

<style>
    body {
        font-style: sans-serif;
    }

/*    .btn {
        text-decoration: none;
        text-align: center;
        font-weight: 700;
        font-size: 1.2rem;
        color: #000000;
        display: inline-block;;
        align-items: center;
        justify-content: center;
        right: 500px;
        top: 900px;
        background-color: #ff6f3b;
        padding: 1rem 1.5rem;
        width: 200px;
        border-radius: 3px;
    }*/

    a {
        text-decoration: none;
    }

    a:hover img {
        opacity: 0.5;
    }

    h3 {
        line-height: 3em;
    }

    .review {
        max-width: 30rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .text-muted {
        font-size: 18px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>