<?php include ROOT . '/views/layouts/header.php'; ?>
    <div id="contact-wrapper">
        <form method="post" action="" id="contactform" OnSubmit='return Validate(this);'>
            <p>
                <label for="name"><strong>Name:</strong></label>
                <input type="text" size="50" name="contactname" id="contactname" value="" class="required" />
            </p>
            <p>
                <label for="email"><strong>Email:</strong></label>
                <input type="text" size="50" name="email" id="email" value="" class="required email" />
            </p>
            <p>
              <label for="subject"><strong>Subject:</strong></label>
              <input type="text" size="50" name="subject" id="subject" value="" />
            </p>
            <p>
              <label for="message"><strong>Message:</strong></label>
              <textarea rows="5" cols="50" name="message" id="message" class="required"></textarea>
            </p>
            <p>Введите код с картинки:</p>
        <br/>
        <p>
            <img style="border: 1px solid gray; background: url('../../template/capha/bg_capcha.png');" 
              src = "../../template/capha/captcha.php" width="120" height="40"/>
        </p>
        <p>
           <input type="text" name="capcha" value="<?php echo $capcha; ?>"/>
        </p>
        <p>
            <input type="submit" value="Send Message" name="submitcallback" class="btn btn-warning" />
        </p>
        </form>
    </div>
    <script src="jquery.min.js" type="text/javascript"></script>
    <script src="jquery.validate.pack.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
           $("#contactform").validate();
      });
    </script> 
    <script type="text/javascript">
    function Validate(obj) {
        var firstName=obj.contactname.value;
        var email=obj.email.value;
        var subject=obj.subject.value;
        var message=obj.message.value;
        var errors="";
        if (firstName=="" || email=="" || subject ==""|| message =="")
        {
            alert("Все поля должны быть заполнены!!");
            return false;
        }
        var reg = /^\w+@\w+\.\w{2,4}$/i;
        if (!reg.test(email))
        {
            errors+="Неправильный e-mail адрес!!\n";
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
