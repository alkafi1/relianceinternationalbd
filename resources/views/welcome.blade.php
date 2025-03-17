<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reliance International</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    .hero-section {
        background: url('hero-bg.jpg') no-repeat center center/cover;
        padding: 100px 0;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('public/frontend/images/' . $global['logo']) }}" alt="Logo" width="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Admin Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('agent.login')}}">Agent Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section bg-dark text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Welcome to Reliance International</h1>
            <p class="lead">Your trusted partner in global trade and services.</p>
            <a href="#" class="btn btn-primary btn-lg">Learn More</a>
        </div>
    </section>

    <section class="services-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Services</h2>
            <div class="row">
                <div class="col-md-4 text-center">
                    <i class="fas fa-globe fa-3x mb-3"></i>
                    <h3>Global Trade</h3>
                    <p>We facilitate seamless international trade.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-ship fa-3x mb-3"></i>
                    <h3>Logistics</h3>
                    <p>Efficient logistics solutions for your business.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-handshake fa-3x mb-3"></i>
                    <h3>Consulting</h3>
                    <p>Expert consulting services for global markets.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('public/frontend/images/' . $global['logo']) }}" alt="About Us" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2>About Us</h2>
                    <p>Reliance International is a leading company in global trade and services. We provide innovative
                        solutions to help businesses grow internationally.</p>
                    <a href="#" class="btn btn-secondary">Read More</a>
                </div>
            </div>
        </div>
    </section>


    <footer class="footer bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p>Email: info@relianceinternational.com</p>
                    <p>Phone: +880 123 456 789</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Home</a></li>
                        <li><a href="#" class="text-white">About</a></li>
                        <li><a href="#" class="text-white">Services</a></li>
                        <li><a href="#" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Follow Us</h5>
                    <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
