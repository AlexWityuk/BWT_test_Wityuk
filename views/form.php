<?php include ROOT . '/views/layouts/header.php'; ?>

<p class="text-primary" style="font-size: 20pt" align='center'>Форма регистрации</p>
<form action="" method="post" align='center'style='margin:5'OnSubmit='return Validate(this);'>
    <p style="margin-left:30px;"><input type="text" name="firstName" placeholder="Имя"/></p>
    <p style="margin-left:30px;"><input type="text" name="lastName" placeholder="Фамилия"/></p>
    <p style="margin-left:30px;"><input type="email" name="email" placeholder="E-mail"/></p>
    <p style="margin-left:30px;"><input type="text" name="usersex" placeholder="Пол" /></p>
    <p style="margin-left:30px;"><input type="text" name="dateofbirth" placeholder="Дата рождения"/></p>
    <input type="submit" name="submit" class="btn btn-success" value="Зарегистрироваться / Вход на сайт" />
</form>
<script type="text/javascript">
    function Validate(obj) {
        var firstName=obj.firstName.value;
        var lastName=obj.lastName.value;
        var email=obj.email.value;
        var usersex=obj.usersex.value;
        var dateofbirth=obj.dateofbirth.value.split('-');
        var errors="";
        if (firstName=="" || lastName=="" || email=="")
        {
            alert("Все поля должны быть заполнены!!");
            return false;
        }
        var reg = /^\w+@\w+\.\w{2,4}$/i;
        if (!reg.test(email))
        {
            errors+="Неправильный e-mail адрес!!\n";
        }
        if (date[0]<1930)
        {
            errors+="Указана неверная дата рождения!!\n";
        }

        if(errors=="")
            return true;
        else
        {
            alert(errors);
            return false;
        }
    }
</script>
<?php include ROOT . '/views/layouts/footer.php'; ?>

