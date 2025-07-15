<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>The Fragrance Company</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('public/images/logo.png') }}">
  
  <!-- Bootstrap CDN (only included once) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
  <!-- Font Awesome CDN (only included once) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- External JavaScript libraries -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo env('APP_URL').'/resources/css/style.css'; ?>">

  <!-- Bootstrap JS Bundle (only included once) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
    <?php 
        if(request()->segment(1) == 'admin' && session('admin_name') == 'admin') { ?>
        @include('viw_navbar')
    <?php } else { ?>
        {{-- @include('viw_user_navbar') --}}
    <?php } ?>
    
