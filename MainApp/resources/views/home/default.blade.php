<!DOCTYPE html>
<html>
<head>
  <title>Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    @yield('css')
    <script type="text/javascript" src="{{ asset('js/angular.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dirPagination.js') }}"></script>
</head>
<body>

<div ng-app="myApp" ng-controller="myCtrl">
  <div class="d-flex flex-row-reverse">
    <div class="p-2">
      <a href="{{ route('logout') }}"><span><i class="fa fa-power-off"></i>&nbsp;Logout</span></a>
    </div>
  </div>
  <div class="jumbotron" height="20%">

    <div class="row">
      <div class="container">
        <h1 class="text-center">Pusher Application</h1>
      </div>
    </div>

    <div class="d-flex justify-content-around">
      <button class="btn btn-primary" ng-click="Devices()">Registeration Lists</button>
      <button class="btn btn-primary" ng-click="Reg()">Push Notification</button>
      <button class="btn btn-primary" ng-click="Search()">Search Registeration Id</button>
    </div>

  </div>
  
  <div class="container">
    @yield('content')
  </div>
  
</div>



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

  <script type="text/javascript" src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>


@yield('js')



  <script src="https://www.gstatic.com/firebasejs/5.4.2/firebase.js"></script>
  <script>
    // Initialize Firebase
    var config = {
      apiKey: "AIzaSyDpyytSnUgjU6RibqFtJgVJo0sMCAnzaG8",
      authDomain: "testdb-667ee.firebaseapp.com",
      databaseURL: "https://testdb-667ee.firebaseio.com",
      projectId: "testdb-667ee",
      storageBucket: "",
      messagingSenderId: "1043781322978"
    };
    firebase.initializeApp(config);
  </script>


</body>
</html>