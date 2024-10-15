<div class="content">
    <div class="title"><span><h2> Форма оформления заказа </h2></span></div>
    <p></p>
    <div class="form"><form action="/order" method= "POST">
            <label><span class="name"> Имя:</span> <br />
                <label style="color: red;">
                    <?php if (!empty($errors['name'])) {
                        print_r($errors['name']);
                    }?>
                </label>
                <input type="search" placeholder="Введите имя" name="name" class="guest"/></label> <p></p>
            <label><span class="phone"> Телефон:</span><br />
                <label style="color: red;">
                    <?php if (!empty($errors['phone'])) {
                        print_r($errors['phone']);
                    }?>
                </label>
                <input type="tel" placeholder="Введите номер телефона без &quot;+7&quot; и &quot;8&quot; " name="phone" class="guest"/></label><p></p>
            <label><span class="address"> Адрес доставки:</span><br />
                <label style="color: red;">
                    <?php if (!empty($errors['address'])) {
                        print_r($errors['address']);
                    }?>
                </label>
                <input type="search" placeholder="Укажите улицу, дом и квартиру" name="address" class="guest"/></label><p></p>
            <label><span class="sum"> Сумма заказа:</span><br />
                <input type="search" name="sum" class="guest"/></label><p></p>
            </select><p></p>
            <div class="bottom">
                <input type="submit" class="bottom1" value="Оформить"/></div>
        </form>
    </div>
</div>
<style>
    .content {
        width: 500px;
        border: 1px solid white;
        font-family: "Times", serif;
    }
    .title{
        width: 500px;
        height: 50px;
        background: DimGrey;
        text-align:center;
        color: white;
        padding: 8px 20px 20px;
    }
    .bottom{
        width: 500px;
        height: 40px;
        background: DimGrey;
        padding: 15px 20px 10px;
    }
    .name::after,.phone::after,.address::after,.sum::after{
        content:"*";
        color:red;
    }
    .bottom1{
        background: SteelGray;
        font-size: 10pt;
        border-radius: 5px;
        border: 1px solid SteelGray;
        padding: 10px 10px;
        width: 100px;
        font-weight:bold;
    }
    .guest {
        width: 380px;
        height: 30px;
        border: 1px solid LightGrey;
    }
</style>