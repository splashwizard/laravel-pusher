@extends('home.default')

@section('css')
<style type="text/css">
	.jumbotron {
	    padding: 2rem 2rem !important;
	}
</style>
@endsection

@section('content')

    <div class="container" ng-show="devicesForm">
      <div class="row">
        <div class="col-sm-4 col-md-4 offset-4">
             <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-search"></i></span>
              <input type="text" class="form-control" ng-model="search" placeholder="search..">
            </div>      
        </div> 
        <div class="pull-right">
          <button class="btn btn-danger" ng-click="remove()"><i class="fa fa-trash"></i>&nbsp;Remove</button>
        </div> 
      </div>
      <table class="table table-striped" at-table at-paginated at-list="list" at-config="config">
        <thead>
          <th>Device ID</th>
          <th>Title</th>
          <th>Content</th>
          <th>Message Url</th>
          <th>Content Available</th>
          <th>Priority</th>
        </thead>
        <tbody>
          <tr dir-paginate="x in devices|orderBy:sortKey:reverse|filter:search|itemsPerPage:5">
            <td ng-bind="x.deviceId"></td>
            <td ng-bind="x.title"></td>
            <td ng-bind="x.content"></td>
            <td ng-bind="x.message_url"></td>
            <td ng-bind="x.content_available"></td>
            <td ng-bind="x.priority"></td>
          </tr>
        </tbody>
      </table>
      <dir-pagination-controls
         max-size="5"
         direction-links="true"
         boundary-links="true" >
      </dir-pagination-controls>
    </div>

    <div class="row">
      <div class="col-sm-4 col-md-4 offset-4" ng-show="regForm">
        <form class="form-horizontal" name="deviceForm" ng-submit="send()" novalidate>
           <h3>Send Pusher Notification</h3>

          <div class="form-group" ng-class="{ 'has-error' : deviceForm.deviceId.$invalid && !deviceForm.deviceId.$pristine }">
              <label for="deviceId">DeviceID</label>
              <input type="text" class="form-control" id="deviceId" name="deviceId" ng-model="device.deviceId"  required>
          </div>

          <div class="form-group" ng-class="{ 'has-error' : deviceForm.titles.$invalid && !deviceForm.titles.$pristine }">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="titles" ng-model="device.titles" ng-minlength="3" ng-maxlength="10" required>
            <p ng-show="deviceForm.titles.$error.minlength" class="help-block">Title is too short.</p>
            <p ng-show="deviceForm.titles.$error.maxlength" class="help-block">Title is too long.</p>
          </div>

          <div class="form-group" ng-class="{ 'has-error' : deviceForm.contents.$invalid && !deviceForm.contents.$pristine }">
            <label for="content">Content</label>
            <input type="text" class="form-control" id="content" name="contents" ng-model="device.contents" required>
          </div>

          <div class="form-group" ng-class="{ 'has-error' : deviceForm.msgUrl.$invalid && !deviceForm.msgUrl.$pristine }">
            <label for="msgUrl">MessageUrl</label>
            <input type="text" class="form-control" id="msgUrl" name="msgUrl" ng-model="device.msgUrl" required>
          </div>

          <div class="form-group" ng-class="{ 'has-error' : deviceForm.contentAvailable.$invalid && !deviceForm.contentAvailable.$pristine }">
            <label for="contentAvailable">Content Available</label>
            <input type="text" class="form-control" id="contentAvailable" name="contentAvailable" ng-model="device.contentAvailable" required>
          </div>

          <div class="form-group" ng-class="{ 'has-error' : deviceForm.priority.$invalid && !deviceForm.priority.$pristine }">
            <label for="priority">Priority</label>
            <input type="text" class="form-control" id="priority" name="priority" ng-model="device.priority" required>
          </div>

            <div class="btn-group">
              <button class="btn btn-success">Back</button>
              <button type="submit" class="btn btn-success" ng-disabled="deviceForm.$invalid">Submit</button>
			      </div>

        </form>

       	<div class="btn-group mt-3 mb-3">
  	      <button class="btn btn-primary">Turn On</button>
  	      <button class="btn btn-primary">Turn Off</button>
		    </div>
      </div>

      <div class="col-sm-6 col-md-6 offset-4" ng-show="searchForm">
      	<form class="form-inline">
    		  <div class="form-group row">
    		    <label for="search" class="col-sm-2 col-form-label">Search</label>
    		    <div class="col-sm-10">
    		      <input type="password" class="form-control" id="search" placeholder="">
    		    </div>
    		  </div>
    		  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>&nbsp;Find</button>
    		</form>
      </div>
    </div>

@endsection



@section('js')

  <script type="text/javascript">



    var app = angular.module("myApp",['angularUtils.directives.dirPagination']);

    var url = "{{ asset('/') }}";

    app.controller("myCtrl",function($scope,$http){


      $scope.devicesForm = true;
      $scope.regForm = false;
      $scope.searchForm = false;


      $http({
        url : url+"api/devices",
        method : "GET",
        contentType : "application/json"
      }).then(function(response){
        var jsObj = angular.fromJson(response.data);
        var obj = jsObj.data;
        $scope.devices = obj;
      });

      $scope.Reg = function(){
	      $scope.regForm = $scope.regForm ? false : true;
	      $scope.searchForm = false;
        $scope.devicesForm = false;     	
      }

      $scope.Search = function(){
        $scope.regForm = false;
        $scope.searchForm = $scope.searchForm ? false : true;
        $scope.devicesForm = false;        	
      }

      $scope.Devices = function(){

        $scope.regForm = false;
        $scope.searchForm = false;
        $scope.devicesForm = $scope.devicesForm ? false : true;

        $http({
          url : url+"api/devices",
          method : "GET",
          contentType : "application/json"
        }).then(function(response){
          var jsObj = angular.fromJson(response.data);
          var obj = jsObj.data;
          $scope.devices = obj;
        });
      }

      $scope.remove = function(){
        if(confirm("Are you sure..")){
          $http({
            url : url+"api/devices/delete",
            method : "DELETE"
          }).then(function(response){

              console.log(response);

              if(response.data.success == true)
              {
                $http({
                  url : url+"api/devices",
                  method : "GET",
                  contentType : "application/json"
                }).then(function(response){
                  var jsObj = angular.fromJson(response.data);
                  var obj = jsObj.data;
                  $scope.devices = obj;
                });
              }
              else
              {
                alert(response.data.message);
              }
          });
        }
      }

      $scope.send = function(){

        if ($scope.deviceForm.$valid) 
        {

          var jsObj = {};

          jsObj["message"] = {
                title: $scope.device.titles,
                content: $scope.device.contents,
                message_url : $scope.device.msgUrl,
                content_available : $scope.device.contentAvailable,
                priority : $scope.device.priority
          };

          jsObj['device_ids'] = [$scope.device.deviceId];

          console.log(jsObj);

          $http({
              url: url+"api/pushers",
              method: "POST",
              contentType: "application/json",
              headers:{ 'Authorization':  'Bearer ' +'nUoyYjz3lvmvtU5JfWSYPh20/9y/G4E2jiL9nCHUJ0Q='},
              data: jsObj
          }).then(function(response){
              console.log(response);
              var jsObj = angular.fromJson(response.data);
              if(jsObj["success"] == true)
              {
                $scope.device.deviceId = '';
                $scope.device.titles = '';
                $scope.device.contents = '';
                $scope.device.msgUrl = '';
                $scope.device.contentAvailable = '';
                $scope.device.priority = '';
                alert(jsObj["message"]);
              }
              else
              {
               alert(jsObj["message"]); 
              }
          });
        }
      }

    });

  </script>


@endsection