<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/7256/7256595.png" type="image/png">
</head>
<style>
@keyframes fadeIn {
  from {
    top: 20%;
    opacity: 0;
  }
  to {
    top: 100;
    opacity: 1;
  }
}

@-webkit-keyframes fadeIn {
  from {
    top: 20%;
    opacity: 0;
  }
  to {
    top: 100;
    opacity: 1;
  }
}

.wrapper {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  -webkit-transform: translate(-50%, -50%);
  animation: fadeIn 1000ms ease;
  -webkit-animation: fadeIn 1000ms ease;
  text-align: center;
}

html {
  height: 100%;
  background: #ffffff url(https://images.unsplash.com/photo-1449168013943-3a15804bb41c?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&w=1080&fit=max&s=1958d4bfb59a246c6092ff0daabd284b) no-repeat center bottom fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

#cspio-headline {
  font-family: 'Pacifico';
  font-weight: 600;
  text-align: center;
  font-size: 70px;
  color: #ffffff;
  line-height: 1.00em;
}

.logo {
  margin-bottom: 20px; /* Adjusts space between logo and headline */
}

.logo img {
  max-width: 300px; /* Adjust as necessary for size */
}
</style>
<body>
    
    <script async src="https://cse.google.com/cse.js?cx=32be073dfcf3e45f1">
</script>
<div class="gcse-search"></div>
    
    
    <div class="wrapper">
        <!-- Logo -->
        <div class="logo">
            <a href="{{ url('/') }}" class="navbar-brand logo logo-title m-0">
                <img src="{{ config('settings.app.logo_url') }}" alt="{{ strtolower(config('settings.app.name')) }}" class="main-logo" 
                     data-bs-placement="bottom" data-bs-toggle="tooltip" title="" />
            </a>
        </div>
        <!-- Headline -->
        <h1 id="cspio-headline">DISCOURSE FORUM IS UNDER CONSTRUCTION</h1>		
    </div>
</body>
</html>
