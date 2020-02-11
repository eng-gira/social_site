<html>
    <head> <title> Home | Ekom </title> </head>
    <body>
        <nav>
            <a href="auth/reg"> Register </a>  |  <a href="auth/logIn"> Log In </a>
        </nav>
        <main>
            <h1> Index View </h1>
            <h3> Available Data: </h3>
            <h4> Id: <?php echo $this->getData()['id']; ?> </h4>
            <h4> Name: <?php echo $this->getData()['name']; ?> </h4>
        </main>
    </body>
</html>