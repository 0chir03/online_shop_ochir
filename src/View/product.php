<div class="container">
  <div class="area-a">
    <div><img src="<?php echo $data->getImage();?>" height="450px" width="450px"></div>
        </div>
          <div class="area-c"><?php echo $data->getName() . ' ' . $data->getDescription() . '<br>' . $data->getPrice() . "<br><br>" . file_get_contents($data->getInfo());?></div>
                <div class="rating-result">
                    <p>Средний рейтинг <?php echo round($averageRating, 1);?></p>
                    <span class="<?php if (floor($averageRating) >= 1) {
                        echo 'active';
                    }?>"></span>
                    <span class="<?php if (floor($averageRating) >= 2) {
                        echo 'active';
                    }?>"></span>
                    <span class="<?php if (floor($averageRating) >= 3) {
                        echo 'active';
                    }?>"></span>
                    <span class="<?php if (floor($averageRating) >= 4) {
                        echo 'active';
                    }?>"></span>
                    <span class="<?php if ($averageRating == 5) {
                        echo 'active';
                    }?>"></span>
            </div>

    <div class="contain">
        <h2>Отзывы</h2>
        <p><?php $this->getReviewService->get($reviews); ?></p>
    </div>
    
    <div class="area-d">
        <form action="/add_review" method="post">
            <input type="hidden" name="product_id" value="<?php echo $data->getId();?>" id="product_id" required>
                <label>
                    Отзыв:<label style="color: red;">
                        <?php if (!empty($errors['comment'])) {
                            print_r($errors['comment']);
                        }?>
                        </label>
                           <textarea name="comment" placeholder="Что вам понравилось?"></textarea>
                        </label>
                            <div class="rating-area">
                                <input type="radio" id="star-5" name="rating" value="5">
                                <label for="star-5" title="Оценка «5»"></label>
                                <input type="radio" id="star-4" name="rating" value="4">
                                <label for="star-4" title="Оценка «4»"></label>
                                <input type="radio" id="star-3" name="rating" value="3">
                                <label for="star-3" title="Оценка «3»"></label>
                                <input type="radio" id="star-2" name="rating" value="2">
                                <label for="star-2" title="Оценка «2»"></label>
                                <input type="radio" id="star-1" name="rating" value="1">
                                <label for="star-1" title="Оценка «1»"></label>
                            </div>
                         <button type="submit">
                       Отправить
                </button>
        </form>
    </div>
</div>

<style>
    .area-a {
        grid-area: big-img;
    }

    .area-c {
        grid-area: desc;
        display: block;
        font-size: 18px;
        margin-left: 10px;

    }
    .area-d {
        margin-left: 150px;
    }

    .container {
        display: grid;
        grid-template-columns: 450px 700px;
        grid-template-areas:
    "big-img desc"
    "big-img desc"
    "big-img desc"
    "small-img desc";
        justify-content:center;
    }

    body {
        display: flex;
        align-items: baseline;
        justify-content: center;
        min-height: 100vh;
        padding: 50px;
        background-color: #18191C;
        color: #9f94ff;
        font-family: "Roboto", sans-serif;
    }
    form div {
        margin-top: 1rem;
    }

    label, input, textarea, button, select{
        font-size: 1.3rem;
        line-height: 1.2
    }

    form {
        width: 30em;
        max-width: 90%;
        margin: 0 auto;
    }

    label {
        margin-bottom: 0.4rem;
        display: block;
    }

    input, textarea {
        padding: 0.4rem;
        width: 100%;
    }

    button {
        margin-top: 2rem;
        background: #9f94ff;
        color: #fff;
        border: none;
        padding: 0.6rem;
    }
    .rating-result {
        text-align: center;
        width: 265px;
        margin: 0 auto;
    }
    .rating-result span {
        padding: 0;
        font-size: 32px;
        margin: 0 3px;
        line-height: 1;
        color: lightgrey;
        text-shadow: 1px 1px #bbb;
    }
    .rating-result > span:before {
        content: '★';
    }
    .rating-result > span.active {
        color: gold;
        text-shadow: 1px 1px #c60;
    }
    .contain {
        border: 2px solid;
        border-radius: 5px;
        padding: 16px;
        margin: 16px 0
    }

    .contain::after {
        content: "";
        clear: both;
        display: table;
    }


    .contain span {
        font-size: 20px;
        margin-right: 15px;
    }

    @media (max-width: 500px) {
        .contain {
            text-align: center;
        }
        .contain img {
            margin: auto;
            float: none;
            display: block;
        }
    }

    .rating-area {
        overflow: hidden;
        width:275px;
        margin: 0 auto;
    }
    .rating-area:not(:checked) > input {
        display: none;
    }
    .rating-area:not(:checked) > label {
        float: right;
        width: 42px;
        padding: 0;
        cursor: pointer;
        font-size: 32px;
        line-height: 32px;
        color: lightgrey;
        text-shadow: 1px 1px #bbb;
    }
    .rating-area:not(:checked) > label:before {
        content: '★';
    }
    .rating-area > input:checked ~ label {
        color: gold;
        text-shadow: 1px 1px #c60;
    }
    .rating-area:not(:checked) > label:hover,
    .rating-area:not(:checked) > label:hover ~ label {
        color: gold;
    }
    .rating-area > input:checked + label:hover,
    .rating-area > input:checked + label:hover ~ label,
    .rating-area > input:checked ~ label:hover,
    .rating-area > input:checked ~ label:hover ~ label,
    .rating-area > label:hover ~ input:checked ~ label {
        color: gold;
        text-shadow: 1px 1px goldenrod;
    }
    .rate-area > label:active {
        position: relative;
    }
</style>