<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
      function onSubmit(token) {
        document.getElementById("demo-form").submit();
      }
    </script>
</head>
<body>
        <form id='demo-form' action="getdata" method="POST">
            @csrf
            <textarea name="message" id="message" cols="30" rows="10"></textarea>
                <div class="g-recaptcha" data-sitekey="6LeJpq4UAAAAACVi168fF8XAYsXMmGXMnRArsetT" data-callback='onSubmit'>Submit</div>
                <br/>
                <button type="submit">ارسال</button>
              </form>
</body>
</html>