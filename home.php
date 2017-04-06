<?session_start();
if($_SESSION['LOGIN_user']==''){
  header("location: index.php");
}?>

<script src="js/function.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaL0ieAkLhzy1rDoLifajeowdXPwTvzmI"></script>
<script type="text/javascript" src="js/date.js"></script>
<script type="text/javascript" src="js/loader.js"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>

<!-- <script type="text/javascript" src="js/label.js"></script>
 -->
<?
 include_once('connect.php');
 include_once('vehicles.php');
 //include_once('History.php');
?>
<script>
function add_schedule_form(start_date){ 

      $("#loading_spinner").show();
      var unit = '<?=$_POST['unit_']?>';
      $.post('new_schedule_from_cal.php',{unit:unit,start_date:start_date},function(data){
          $('#schedule_abbr').hide();
          $("#sch_view_div").empty();
          $("#sch_view_div").html(data);
          $('#sch_view_div').show();
          $("#loading_spinner").hide();
      });
      //$("#schedule_month").load("new_sch_cal.php");
      
}
function event_calender(unit){ 
  
  $("#loading_spinner").show();
  //view = $("#sch_view").val();
$.post( "events_calendar.php",{ unit: unit },function(data) {
    $('#sch_view_div').hide();
    $("#sch_view_div").empty();
    $("#schedule_abbr").html(data);
    $('#schedule_abbr').show();
    $("#loading_spinner").hide();
    });
}


function add_motel(unit){
  //alert(unit);
  $('#sch_view_div').hide();
$.ajax({
            type: 'post',
            url: 'new_sch_cal_get.php',
            //data: $('#form'+unit).serialize(),
            data:"unit="+unit,
            success: function (data) {  //alert(data);
             $("#schedule_abbr").empty();
             $("#schedule_abbr").html(data);
             $('#schedule_abbr').show();
             //$("#loading_indicator").hide();
            }
                        
            });
}

function back_to_list(){
     $("#schedule_abbr").empty();
     $("#schedule_abbr").load('Schedule_Calendar.php');
}



function Label(opt_options,height) 
{
  //initialize_both(LocationData,substationData);
  //alert(height);
  //alert('test');
 // Initialization
 this.setValues(opt_options);

 // Label spcific
 var span = this.span_ = document.createElement('span');
 span.style.cssText = 'position: relative; left: -50%; top: '+height+'px; ' +
                      'white-space: nowrap; border: 1px solid blue; ' +
                      'padding: 2px; background-color: white';

 var div = this.div_ = document.createElement('div');
 div.appendChild(span);
 div.style.cssText = 'position: absolute; display: none';
};
Label.prototype = new google.maps.OverlayView;

// Implement onAdd
Label.prototype.onAdd = function() {
 var pane = this.getPanes().overlayLayer;
 pane.appendChild(this.div_);

 // Ensures the label is redrawn if the text or position is changed.
 var me = this;
 this.listeners_ = [
   google.maps.event.addListener(this, 'position_changed',
       function() { me.draw(); }),
   google.maps.event.addListener(this, 'text_changed',
       function() { me.draw(); })
 ];
};

// Implement onRemove
Label.prototype.onRemove = function() {
 this.div_.parentNode.removeChild(this.div_);

 // Label is removed from the map, stop updating its position/text.
 for (var i = 0, I = this.listeners_.length; i < I; ++i) {
   google.maps.event.removeListener(this.listeners_[i]);
 }
};

// Implement draw
Label.prototype.draw = function() {
 var projection = this.getProjection();
 var position = projection.fromLatLngToDivPixel(this.get('position'));

 var div = this.div_;
 div.style.left = position.x + 'px';
 div.style.top = position.y + 'px';
 div.style.display = 'block';

 this.span_.innerHTML = this.get('text').toString();
};

function dispatch(lati,longi){  // on right click of map,for dispatch
//alert(lati+','+longi);
$('#dyn_back').show('slide', { direction: 'left' }, 1000);
      if(backarray[backarray.length-1] != 'Dispatch'){
            backarray.push('Dispatch');
            }
        $(".current_view").hide();
        $("#sel_view").val('Dispatch');
        $("#Dispatch").html('');
        $('#Dispatch').show();
        $('.multiselect,#d_map').attr('disabled', 'disabled');
        if($("#Dispatch").html().trim()==''){
          $("#Dispatch").html("<center><img src='image/spinner.gif'> <strong>Please wait ....</strong></center>");
          $.post( "dispatch.php",{ status:is_dispatch_map,curr_lati: lati,curr_longi: longi },function(data) { 
            //alert(data);
           $("#Dispatch").html(data);
        });
          //$("#Search").load("search.php");
              }

}

 function nearest_veh_search(lati,longi){
  //alert(lati);
          $('#dyn_back').show('slide', { direction: 'left' }, 1000);
      if(backarray[backarray.length-1] != 'Activity Search'){
            backarray.push('Activity Search');
            }
        $(".current_view").hide();
        $("#sel_view").val('Activity Search');
        $("#Activity_Search").html('');
        $('#Activity_Search').show();
        $('.multiselect,#d_map').attr('disabled', 'disabled');
        if($("#Activity_Search").html().trim()==''){
          $("#Activity_Search").html("<center><img src='image/spinner.gif'> <strong>Please wait ....</strong></center>");
          $.post( "activity_search.php",{ status:is_activity_map,curr_lati: lati,curr_longi: longi },function(data) { 
            //alert(data);

            $("#Activity_Search").html(data);
        });
          //$("#Search").load("search.php");
              }
}
function ZoomControl(controlDiv, map) {
  
  // Creating divs & styles for custom zoom control
  controlDiv.style.padding = '5px';

  // Set CSS for the control wrapper
  var controlWrapper = document.createElement('div');
  //controlWrapper.style.backgroundColor = 'white';
  //controlWrapper.style.borderStyle = 'solid';
  //controlWrapper.style.borderColor = 'gray';
  //controlWrapper.style.borderWidth = '1px';
  controlWrapper.style.cursor = 'pointer';
  controlWrapper.style.textAlign = 'center';
  controlWrapper.style.width = '70px'; 
  controlWrapper.style.height = '86px';
  controlDiv.appendChild(controlWrapper);
  
  // Set CSS for the zoomIn
  var zoomInButton = document.createElement('div');
  zoomInButton.style.width = '73px'; 
  zoomInButton.style.height = '32px';
  zoomInButton.innerHTML = '<input type="checkbox" '+activeall_checked+' id="active_veh" onclick=isactive(this.checked) ><b>Active Only</b>';

  /* Change this to be the .png image you want to use 
  zoomInButton.style.backgroundImage = 'url("http://placehold.it/32/00ff00")';*/
  controlWrapper.appendChild(zoomInButton);

  var zoomInButton1 = document.createElement('div');
  zoomInButton1.style.width = '64px'; 
  zoomInButton1.style.height = '32px';
  zoomInButton1.innerHTML = '<input type="checkbox" '+label_checked+' id="active_label" onclick=isactive_label(this.checked) ><b>Labels On</b>';
  
  /* Change this to be the .png image you want to use 
  zoomInButton.style.backgroundImage = 'url("http://placehold.it/32/00ff00")';*/
  controlWrapper.appendChild(zoomInButton1);
    
  // Set CSS for the zoomOut
  var zoomOutButton = document.createElement('div');
  zoomOutButton.style.width = '70px'; 
  zoomOutButton.style.height = '54px';
  zoomOutButton.style.backgroundSize = '100% 100%';
  zoomOutButton.style.backgroundImage = 'url(image/map/zoom_all.png)';
  /* Change this to be the .png image you want to use */
  controlWrapper.appendChild(zoomOutButton);

  // Setup the click event listener - zoomIn
  google.maps.event.addDomListener(zoomInButton, 'click', function() {
    //alert(document.getElementById("active_veh").value);
    //map.setZoom(map.getZoom() + 1);
  });
    
  // Setup the click event listener - zoomOut
  google.maps.event.addDomListener(zoomOutButton, 'click', function() {
    
   iszoomchanged = true;
   currentzoomlevel = 7;
   initialize_both(LocationData,substationData);
   imei_arr = [];
    $('.multiselect').removeAttr("disabled");
   $("#d_map").val('');
     $("#clear_searchtext").hide();
  });  
    
}

//testing git


  function HomeControl(controlDiv, map) {
  controlDiv.style.padding = '5px';
  var controlUP = document.createElement('div');
  controlUP.style.backgroundImage = 'url(image/map/u.png)';
  controlUP.style.backgroundSize = '100% 100%';
  //controlUP.style.border='1px solid';
  controlUP.style.cursor = 'pointer';
  controlUP.style.width = '30px';
  controlUP.style.height = '30px';
  controlUP.style.marginLeft = '18px';
  controlUP.title = 'UP';
  controlDiv.appendChild(controlUP);
  var controlLEFT = document.createElement('div');
  controlLEFT.style.backgroundImage = 'url(image/map/l.png)';
  controlLEFT.style.backgroundSize = '100% 100%';
  //controlLEFT.style.border='1px solid';
  controlLEFT.style.cursor = 'pointer';
  controlLEFT.style.width = '30px';
  controlLEFT.style.height = '30px';
  controlLEFT.style.float = 'left';
  controlLEFT.title = 'Left';
  controlDiv.appendChild(controlLEFT);
  var controlRight = document.createElement('div');
  controlRight.style.backgroundImage = 'url(image/map/r.png)';
  controlRight.style.backgroundSize = '100% 100%';
  //controlRight.style.border='1px solid';
  controlRight.style.cursor = 'pointer';
  controlRight.style.width = '30px';
  controlRight.style.height = '30px';
  controlRight.style.marginLeft = '34px';
  controlLEFT.style.float = 'left';
  controlRight.title = 'Right';
  controlDiv.appendChild(controlRight);
  var controlDown = document.createElement('div');
  controlDown.style.backgroundImage = 'url(image/map/d.png)';
  controlDown.style.backgroundSize = '100% 100%';
  //controlDown.style.border='1px solid';
  controlDown.style.cursor = 'pointer';
  controlDown.style.width = '30px';
  controlDown.style.height = '30px';
  controlDown.style.marginLeft = '18px';
  controlDown.title = 'Down';
  controlDiv.appendChild(controlDown);
  
  google.maps.Map.prototype.panToWithOffset = function(latlng, offsetX, offsetY) {
    var map = this;
    var ov = new google.maps.OverlayView();
    ov.onAdd = function() {
        var proj = this.getProjection();
        var aPoint = proj.fromLatLngToContainerPixel(latlng);
        aPoint.x = aPoint.x+offsetX;
        aPoint.y = aPoint.y+offsetY;
        map.panTo(proj.fromContainerPixelToLatLng(aPoint));
    }; 
    ov.draw = function() {}; 
    ov.setMap(this); 
};
  
  google.maps.event.addDomListener(controlUP, 'click', function() {
  map.panToWithOffset(map.getCenter(), 0, -100);
  });
  google.maps.event.addDomListener(controlLEFT, 'click', function() {
  map.panToWithOffset(map.getCenter(), -100, 00);
  });
  google.maps.event.addDomListener(controlRight, 'click', function() {
  map.panToWithOffset(map.getCenter(), 100, 00);
  });
  google.maps.event.addDomListener(controlDown, 'click', function() {
  map.panToWithOffset(map.getCenter(), 0, 100);
  });
 
}
   var LocationData = <?=$finalString?>;
   var view_details = '<?=$_SESSION['ROLE_view']?>';//alert(view_details);
   if(view_details != '0'){
     var view_array = view_details.split(',');
   }
   var substfinalarray = '';
   var map;
   var image ;
   var bounds;
   var bounds_poi;
   var infowindow;
   var centerMap;
   var sites;
   var latlng;
   var marker;
   var zoomval = 15;
   var is_fitbound = 1;
   var substationData;
   var mapLat; 
   var mapLng;
   var savedMapZoom; 
   var mapCentre; 
   var show_custom = 1; 
   var myMapType = google.maps.MapTypeId.ROADMAP;
   var jbus_imei_show='';
   var personnel_imei_show='';
   var veh_green=0;
   var veh_red=0;
   var veh_yellow=0;
   var veh_grey=0;
   var veh_count;
   var isfitbounds = false;
   var options = '';
    var copy_equip_opt = '';
    var copy_poi_opt = '';
    var copy_driv_opt = '';
    var copy_unit_opt = '';
    var copy_crew_opt = '';
    var copy_tag_opt = '';
    var eqp_data;
    var is_history_load = false;
    var trip_list = new Array();
  
   var imei_arr = new Array();
   var backarray = new Array();
    backarray = ['Map'];
   var is_dash_open = 1;
  var is_activity_map=1;
  var is_dispatch_map=1;
  var activeall_checked = 'checked=checked';
  var label_checked ='';
   var set_int = null;
   var is_track_list_show = false;
   var is_search = false;
  <?if($_SESSION['LOGIN_role']=='blanket' || $_SESSION['LOGIN_role']=='schedule_admin' || $_SESSION['LOGIN_role']=='role_storm'){ ?>
    var activeall_checked ='';
  <? } ?>
function isactive(bolean_active){
    if(bolean_active==true){
    activeall_checked = 'checked=checked';
    }else{
    activeall_checked = '';
    }
  initialize_both(LocationData,substationData);

  //right_click_event();
      //$("#d_map").val('');
}
function isactive_label(bolean_active_lable){
    if(bolean_active_lable==true)
    {
    label_checked = 'checked=checked';
    }
    else
    {
   label_checked = '';
    }
      savedMapZoom=map.getZoom(); 
       mapCentre=map.getCenter(); 
                mapLat=mapCentre.lat(); 
                mapLng=mapCentre.lng();
  initialize_both(LocationData,substationData);
  map.setCenter(new google.maps.LatLng(mapLat,mapLng));
             map.setZoom(savedMapZoom);
}


   function drawChart() {

        var data = google.visualization.arrayToDataTable(veh_count);

        var options = {
        title: '',
        pieStartAngle: 90,
        legend: 'none',
        'is3D':true,
        colors: ['#1DAB31', '#B41716', 'yellow', '#777777'],
        chartArea:{left:0,top:0,width:'100%',height:'100%'},
        backgroundColor: { fill:'transparent' }
      };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    function zoomondevice(imei,index){
     // imei_arr[0]=imei;
     // initialize(filter_eqptype(imei_arr,LocationData,index));
     // $("#d_map").val('');
     infowindow.close();
       var test_arr = new Array();
     test_arr[0] = imei;
         filterdata = filter_eqptype(test_arr,LocationData,index);
     sites_filter = filterdata[0];
     map.setCenter(new google.maps.LatLng(sites_filter[3], sites_filter[4]));
     map.setZoom(17);
     $("#d_map").val('');
    }


/*function back(){

   $("#map-canvas1").hide();
   $("#Search").html('');
    $(".current_view").show();
        $('#Search').hide();
        initialize_both(LocationData,substationData);
        $('.multiselect').removeAttr("disabled");
        $("#d_map").val('');
        $("#clear_searchtext").hide();
        // right_click_event();
        infowindow.close();
        //
}*/

  function followondevice(imei,index)
  {
     
     imei_arr[0]=imei;
       initialize(filter_eqptype(imei_arr,LocationData,index));
       $("#d_map").val('');
    
    }


  function zoompoi(lati,longi){
    map.setCenter(new google.maps.LatLng(lati,longi));
    map.setZoom(18);
  }

    function addListenerevent(marker,map,show_custom)
    {
    
     if(show_custom){
        var homeControlDiv = document.createElement('div');
        var homeControl = new HomeControl(homeControlDiv, map);
        var zoomControlDiv = document.createElement('div');
        var zoomControl = new ZoomControl(zoomControlDiv, map);
        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(homeControlDiv);
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(zoomControlDiv);
    show_custom= 0;
      }
     google.maps.event.addListener(marker, "click", function () {
          infowindow.setContent(this.html);
     infowindow.open(map, this);
        });
    return show_custom;
     //map.fitBounds(bounds);
    }

var currentzoomlevel = 7;
var iszoomchanged = false;


function initialize(LocationData)
{
      var myOptions =
        {
          mapTypeId: myMapType,
        }
    map = new google.maps.Map(document.getElementById('map-canvas'), myOptions);
    initialize_map(LocationData);
}



function initialize_map(LocationData)
{ //alert(LocationData);
  show_custom = 1; 
   if(LocationData!=null && LocationData!='')
   {
 
    bounds = new google.maps.LatLngBounds();
    infowindow = new google.maps.InfoWindow();
    veh_green=0;
    veh_red=0;
    veh_yellow=0;

    for (var i = 0; i < LocationData.length; i++)
    { 
         sites = LocationData[i]; 
    latlng = new google.maps.LatLng(sites[3], sites[4]);

  var asoff = '';
  if(sites[50] != '')
  {
    var asoff = '<br> <strong>As Off:</strong> '+sites[50];
  }
    
    if(sites[21]=='Mobile Substation' || sites[21]=='Mobile Switch')
  {
      var addon = '<br> <strong>Unit #:</strong> '+sites[41]+
                '<br> <strong>Voltage:</strong> '+sites[43]+
                '<br> <strong>MVA:</strong> '+sites[44];
      var title_onover = sites[1];
      var title_lavel = sites[41];
    }
  else if(sites[21]=='F-150' || sites[21]=='F-250' || sites[21]=='F-350' || sites[21]=='Sedan' || sites[21]=='SUV' || sites[21].indexOf("Truck")>0 )
  {
      var addon = '<br> <strong>Crew:</strong> '+sites[42]+
          '<br> <strong>Driver:</strong> '+sites[24]+asoff+
          '<br> <strong>Driver Phone#:</strong> '+sites[31]; 
      var title_onover = sites[1];
      var title_lavel = sites[1];
    }
  else if(sites[37]=='Computer')
  {
      
      if (sites[21] != 'Personnel') 
      {
        var tmp = sites[1];
        sites[1] = sites[18];
        sites[18] = tmp;
        var addon = '<br> <strong>Battery :</strong> '+sites[15]+' %'+
              '<br> <strong>User Name:</strong> '+sites[18]+
              '<br> <strong>User Phone#:</strong> '+sites[20]; 
      }
      else
      {
        var addon = '<br> <strong>User Name:</strong> '+sites[1]+
              '<br> <strong>User Phone#:</strong> '+sites[20]; 
      }
      var title_onover = sites[1] ;
      var title_lavel = sites[1] ;
    }
  else
  { 
      var addon = '<br> <strong>Crew:</strong> '+sites[42]+
                '<br> <strong>Driver:</strong> '+sites[24]+asoff+
                '<br> <strong>Driver Phone#:</strong> '+sites[31]; 
    var title_onover = sites[1];
    var title_lavel = sites[1];
    }
    var batt_level='';
// For location Metering Services
if(sites[37]=='OBDII'){
   batt_level = '<br> <strong>Battery:</strong> '+sites[15];
}

  var workgroup = '<br> <strong>Work Group:</strong> '+sites[51];


    if(sites[37]=='JBUS')
  {
            var forjbus = '<br><input type="button" value="Engine Details" onclick="view_engine('+sites[20]+' ,'+sites[1]+' ,\''+sites[2]+'\' ,\''+sites[21]+'\' ,\''+sites[24]+'\' ,\''+getmarkerstate(sites)+'\' ,'+sites[15]+','+sites[6]+'0,0)" ><img id="'+sites[20]+'" src=\'image/spinner.gif\' width=\'15px;\' style=\'display:none;\'>';
    }
  else
  {
      var forjbus = '';
    }

    if(sites[21] == 'Personnel')
  {
        var forpersonnel='<br><input type="button" value="Assets" onclick="view_assets('+set_int+',\''+sites[1]+'\',\''+sites[20]+'\',null)" ><img id="'+sites[20]+'" src=\'image/spinner.gif\' width=\'15px;\' style=\'display:none;\'>';
    }
  else
  {
         var forpersonnel='';
    }
    
    if(sites[37]=='Computer')
  {
      if (sites[21] != 'Personnel') 
      {
         var forcomp_det = '<br> <strong>MAC Address:</strong> '+sites[20];
         //alert($forcomp_det);
      }
      else
      {
        var forcomp_det = '<br> <strong>Equipment Detail: </strong> Phone';
      }
            var trip = '';
            //alert(trip);

    }
  else
  {
            var forcomp_det = '<br> <strong>Equipment Detail:</strong> '+sites[47];
            // sites[36]='undefined';
            var trip = '<br> <strong>Trip sheet:</strong><img id="'+sites[36]+'" src=\'image/spinner.gif\' width=\'15px;\' style=\'display:none;\'> <a style=\'cursor:pointer;\' onclick=edit_ts('+sites[36]+')  >'+sites[36]+'</a>';
    }

     if (sites[33] < 1 && sites[21] != 'Personnel') 
     {
     var event = '<br><strong>Event: </strong>'+getmarkerstate(sites);
     }
   else  if (sites[21] != 'Personnel') 
   {
      var event = '<br><strong>Last Event: </strong>'+sites[32]+' <strong>Status: </strong> Inactive';
     }
   else
   {
    var event = "";
   }
   var manage = "";
   //alert(view_details);
  if(($.inArray("1",view_array) != -1)  || view_details == '0'){
    manage = '<br><input type="button" name="manage" id="manage" value="Manage" style="margin-bottom:1vh;" onclick=edit_tracker_map("'+sites[20].trim(' ')+'")><img id="manage_spin" src=\'image/spinner.gif\' width=\'15px;\' style=\'display:none;\'>';
  }

    var history24 = '<input type="button" value="24 Hr History" onclick=\'gethistory("'+sites[20].replace("-", "/")+'","'+(Date.today().add(-1).days().toString("yyyy-MM-dd"))+' '+(new Date().toString("HH:mm"))+'","'+(new Date().toString("yyyy-MM-dd HH:mm"))+'","","","'+sites[1]+'")\' >';
     
              html = '<b>Device Name:</b> '+sites[1]+
                '<br> <strong>Equipment Type:</strong> '+sites[21]+forcomp_det+addon+event+
                '<br> <strong>POI:</strong> '+sites[34]+workgroup+
                '<br> <strong>Last Location:</strong> '+(new Date(sites[0].replace("-", "/")).toString("MM-dd-yyyy hh:mm tt"))+
                trip+batt_level+manage+
                '<br><input type="button" value="Zoom In" onclick=zoomondevice("'+sites[20]+'",20) > '+history24+
         '<input type="button" value="Follow" onclick=followondevice("'+sites[20]+'",20) >'+forjbus+forpersonnel ;
         bounds.extend(latlng);
      marker = new google.maps.Marker({
            position: latlng,
            zoom: zoomval,
            //draggable: true,
            map: map,
            zIndex:999,
            icon: setimage(sites[33],sites[2],sites[48],sites[10],currentzoomlevel),
      title: title_onover,
            html: html
        });
      markerCluster.addMarker(marker, true); // for clustering....
            marker_array.push(marker);// array for clustering...

  if(label_checked!=''){
    var label = new Label({
       map: map
     },
     getimagesize(sites[33],sites[2],sites[48],sites[10]));
     label.bindTo('position', marker, 'position');
     //label.bindTo('text', marker, 'title');
   label.set('text', title_lavel);
}
     veh_count = get_veh_counts(sites[33],sites[2]);
     var ignonper = ((veh_count[1][1]*100)/veh_total).toFixed(2);
     var ignoffper = ((veh_count[2][1]*100)/veh_total).toFixed(2);
     var inactper = ((veh_count[4][1]*100)/veh_total).toFixed(2);
     document.getElementById("count").innerHTML = 'Activity '+ignonper+'%';
         show_custom = addListenerevent(marker,map,show_custom);
      }

      map.fitBounds(bounds);
      if(isfitbounds)
      {
         map.setCenter(new google.maps.LatLng(mapLat,mapLng));
           map.setZoom(savedMapZoom);
      }
      
     }
     else
     {
      set_center_map();
     }


    map.addListener('zoom_changed', function()
    {
      
      if( currentzoomlevel != map.getZoom())
      {
          currentzoomlevel = map.getZoom();
        iszoomchanged = true;
      }
    });
}

function edit_tracker_map(tsn){
    $("#manage_spin").show(); 
  $.ajax({
            type: "POST",
            url: "edit_tracker_map.php",
            data: "imei="+tsn,
            success: function(data) { //alert(data);
        $("#trip_sheet_div").html("");
        $("#trip_sheet_div").html(data); 
        $("#trip_sheet_div").show();
        $("#manage_spin").hide();
            }
        });
}

function initialize_poi(LocationData)
{ //map = new google.maps.Map(document.getElementById('map-canvas'));
  if(LocationData!=null && LocationData!='')
  {
     //bounds = new google.maps.LatLngBounds();
     infowindow = new google.maps.InfoWindow();
   for (var i = 0; i < LocationData.length; i++)
   { 
         sites = LocationData[i];
        if(sites[4]=='sub'){sites[4]='gpc subs';}
         image = 'image/poi/'+sites[4].replace('/', "&")+'.png';
         latlng = new google.maps.LatLng(sites[2], sites[3]);
         //if(is_fitbound)
         bounds.extend(latlng);
        //image = setimage(sites[33],sites[2]);
    if(sites[8]!='')
    {
      var camera_btn = '<input type="button" value="Camera" onclick=get_image_list('+sites[0]+',"'+sites[8]+'",0,"'+sites[9]+'") ><img id="poi_'+sites[0]+'" src=\'image/spinner.gif\' width=\'15px;\' style=\'display:none;\'>';
    }
    else
    {
      var camera_btn = '';
    }
         marker = new google.maps.Marker({
            position: latlng,
            zoom: zoomval,
            map: map,
            icon: image,
            zIndex:0,
            title: sites[1],
            html: sites[0]+' '+sites[1]+'<br><input type="button" value="Zoom In" onclick=zoompoi('+sites[2]+','+sites[3]+') > '+camera_btn
        });
        show_custom = addListenerevent(marker,map,0);
    
        }
    map.fitBounds(bounds);
    if(isfitbounds)
    {
         map.setCenter(new google.maps.LatLng(mapLat,mapLng));
         map.setZoom(savedMapZoom);
    }
     }
   else
   {
    set_center_map();
   }
}

function right_click_event()
{
   infowindow = new google.maps.InfoWindow();
   google.maps.event.addListener(map, "rightclick", function(event) 
   {
    var lat = event.latLng.lat();
    var lng = event.latLng.lng();
    var contentString = $('<center><div><input type="button" value="Activity By Location" onclick="nearest_veh_search('+lat+','+lng+')"><br><input type="button" value="Dispatch" style="margin-top:1vh;margin-bottom:1vh;" onclick="dispatch('+lat+','+lng+')"></div></center>'); 
            
         infowindow.setContent(contentString[0]);
         infowindow.setPosition(event.latLng);
    
     infowindow.open(map); 
    });


    google.maps.event.addListener(map, 'mousedown', function(){ 
    clearTimeout(map.pressButtonTimer); 
    map.pressButtonTimer = setTimeout(function(){ 
      //alert("Hello");
    }, 2000); 
  }); 

    google.maps.event.addListener(map, "click", function(event)
    {
        infowindow.close();
    });
 }



 

function initialize_poi_both(LocationData)
{ 
  if(LocationData!=null && LocationData!='')
  {
     //bounds = new google.maps.LatLngBounds();
     infowindow = new google.maps.InfoWindow();
   for (var i = 0; i < LocationData.length; i++)
   { 
         sites = LocationData[i];
         if(sites[4]=='sub'){sites[4]='gpc subs';}
         image = 'image/poi/'+sites[4].replace('/', "&")+'.png';
         latlng = new google.maps.LatLng(sites[2], sites[3]);
         bounds.extend(latlng);
       if(sites[8]!='')
     {
      var camera_btn = '<input type="button" value="Camera" onclick=get_image_list('+sites[0]+',"'+sites[8]+'",0,"'+sites[9]+'") ><img id="poi_'+sites[0]+'" src=\'image/spinner.gif\' width=\'15px;\' style=\'display:none;\'>';
     }
     else
     {
      var camera_btn = '';
     }
         marker = new google.maps.Marker({
            position: latlng,
            zoom: zoomval,
            map: map,
            icon: image,
            zIndex:0,
            title: sites[1],
            html: sites[0]+' '+sites[1]+'<br><input type="button" value="Zoom In" onclick=zoompoi('+sites[2]+','+sites[3]+') > '+camera_btn
        });
        show_custom = addListenerevent(marker,map,0);
        }
    map.fitBounds(bounds);
    if(isfitbounds)
    {
         map.setCenter(new google.maps.LatLng(mapLat,mapLng));
         map.setZoom(savedMapZoom);
    }
     }
   else
   {
    //set_center_map();
   }
}

function long_press_zoom(){
  var longpress = false;
var longpress_status='';
    google.maps.event.addListener(map,'click', function (event) {
            (longpress) ? longpress_status="Long Press" : longpress_status="Short Press";
            //alert(longpress_status);
                var long_press_lat = event.latLng.lat();
                var long_press_longi = event.latLng.lng();
            if(longpress_status == "Long Press"){
              //alert(map.getZoom());
              map.setCenter(new google.maps.LatLng(long_press_lat,long_press_longi));

              map.setZoom(map.getZoom()+1);
            }
        });

    google.maps.event.addListener(map, 'mousedown', function(event){

                start = new Date().getTime();           
            });

    google.maps.event.addListener(map, 'mouseup', function(event){

                end = new Date().getTime();
                    longpress = (end - start < 500) ? false : true;         

            });
  }


google.maps.event.addDomListener(window, 'load', function()
{
   // initialize(LocationData);



      var event_arr = new Array();
     event_arr[0]=0;
    <?if($_SESSION['LOGIN_role']=='blanket' || $_SESSION['LOGIN_role']=='schedule_admin' || $_SESSION['LOGIN_role']=='role_storm'){ ?>
      event_arr[0]=2;
    <? } ?>

  veh_total=LocationData.length;

  <? if($_SESSION['LOGIN_veh_from_API']!=''){ ?>
     <?if($_SESSION['LOGIN_role']=='blanket' || $_SESSION['LOGIN_role']=='schedule_admin' || $_SESSION['LOGIN_role']=='role_storm'){ ?>
      initialize(filter_eqptype(["<?=$_SESSION['LOGIN_veh_from_API']?>"],LocationData,1));
    <? } else {?>
       initialize(filter_eqptype(event_arr,filter_eqptype(["<?=$_SESSION['LOGIN_veh_from_API']?>"],LocationData,1),33));
  <? }?>


      
    <? unset($_SESSION['LOGIN_veh_from_API']); ?>
  <? } else{ ?>

    <?if($_SESSION['LOGIN_role']=='blanket' || $_SESSION['LOGIN_role']=='schedule_admin' || $_SESSION['LOGIN_role']=='role_storm'){ ?>
      initialize(LocationData);
    <? } else {?>
       initialize(filter_eqptype(event_arr,LocationData,33));
  <? }?>
        


  <? } ?>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
     /* google.maps.event.addListener(map, "rightclick", function(event) {
    var lat = event.latLng.lat();
    var lng = event.latLng.lng();
    var contentString = $('<div><input type="button" value="Search" onclick="nearest_veh_search('+lat+','+lng+')"></div>');
            infowindow = new google.maps.InfoWindow();
              infowindow.setContent(contentString[0]);

   infowindow.setPosition(event.latLng);
    
   

     infowindow.open(map);
});
 google.maps.event.addListener(map, "click", function(event) {
    infowindow.close();
  });*/
right_click_event();
long_press_zoom();
//this.setValues(opt_options);
setTimeout(function(){
     initialize_both(LocationData,substationData);
  },3000);
});

setInterval(function()
{ 

  if(iszoomchanged)
  {
        iszoomchanged = false;

        myMapType = map.getMapTypeId();
                savedMapZoom=map.getZoom(); 
                mapCentre=map.getCenter(); 
                mapLat=mapCentre.lat(); 
                mapLng=mapCentre.lng();
                if($("#d_map").val()=='')
                {
                  if(imei_arr.length==0)
                  {
                    initialize_both(LocationData,substationData);
                  }
                  else
                  {
                     filtered_arr = filter_eqptype(imei_arr,LocationData,21).concat(filter_eqptype(imei_arr,LocationData,20));
                     initialize(filtered_arr);
           if(filtered_arr.length==1)
                     {
              mapLat= filtered_arr[0][3];
              mapLng= filtered_arr[0][4];
           }
                  }

                }
                else
                {

                  if(imei_arr.length==0)
                  {
            //initialize_both(LocationData,substationData);
                  var test_arr = new Array();
                  test_arr[0] = $("#d_map").val();
                  initialize_both(filter_veh_search(test_arr[0],LocationData),substationData);
           
                  }
                  else
                  {
                     filtered_arr = filter_eqptype(imei_arr,LocationData,21).concat(filter_eqptype(imei_arr,LocationData,20));
                     initialize(filtered_arr);
                     if(filtered_arr.length==1)
                     {
                           mapLat= filtered_arr[0][3];
                           mapLng= filtered_arr[0][4];
                     }
                  }


                  if($('#sel_type option:selected').val()=='POI')
                  {
                    var test_arr = new Array();
                    test_arr[0] = $("#d_map").val();
                    filterdata_search = filter_eqptype(test_arr,substationData,1);
                    if(filterdata_search.length>0)
                    {
                             initialize_poi(filterdata_search);
                    }
                  }
                }
               right_click_event(); 
              long_press_zoom();
              map.setCenter(new google.maps.LatLng(mapLat,mapLng));
              map.setZoom(savedMapZoom);
  }
  
}, 3000); 

 
setInterval(function()
{ 
    if($("#sel_view option:selected").text()=='Map')
  {
        map_refresh();
        if(jbus_imei_show!=''){
          var jbus_details = filter_eqptype([jbus_imei_show],LocationData,20);
          var jbus_details_arr = jbus_details[0];
          view_engine(jbus_details_arr[20],jbus_details_arr[1],jbus_details_arr[2],jbus_details_arr[21],jbus_details_arr[24],getmarkerstate(jbus_details_arr),jbus_details_arr[15],jbus_details_arr[6],0,is_dash_open);
        }
    else
    {
         
        }
    } 
    else if($("#sel_view option:selected").text()=='Board'){
      $('#board_spinner').show();
      var board_var = $('#board_json').val();
      $.post( "Board.php",{board_json : board_var },function(data) {
            $(".board").html('');
            $(".board").html(data);
            $('#board_spinner').hide();
            ShowLocalDate();
      });
    }
    else if($("#sel_view option:selected").text()=='Admin'){
      if(is_track_list_show){
      $('#tracker_loading').show();
      //$("#tracker_tbl_body").load('tracker_tbl_body.php');
        var company = $('#opco_filter').val().join();
        var section = $('#primary_filter').val().join();
        var business_unit = $('#group_filter').val().join();
        var location = $('#dept_filter').val().join();
        var workgroup = $('#wrkgrp_filter').val().join();
        var tracker_type = $("#trackertype_filter").val().join();
        var equipment = $('#equipment_filter').val().join();
        $.post('tracker_tbl_body.php',{company:company,section:section,business_unit:business_unit,location:location,workgroup:workgroup,tracker_type:tracker_type,equipment:equipment},function(data){
          //alert(data);
          $('#tracker_loading').hide();
          $('#tracker_tbl_body').html('');
          $('#tracker_tbl_body').html(data);
          filter_table('','','',$("#search_filter").val(),'','','',$("#tracker_tbl_body"));

        });
      }
      /*  
        $.post( "tracker_tbl_body.php",{},function(data) {
            $("#tracker_tbl_body").html(data);
              filter_table($("#opco_filter option:selected").val(),
              $("#primary_filter option:selected").val(),
              $("#equipment_filter option:selected").val(),
              $("#search_filter").val(),
              $("#trackertype_filter option:selected").val(),
              '',
              '',
              $("#tracker_tbl_body"));
          $('#tracker_loading').hide();
        });*/
      ShowLocalDate();
    }
    else if($("#sel_view option:selected").text()=='Trip Sheet' && trip_list.length==0){
      $("#ts_refresh_spinner").show();

/*
        var req_date =  $("#d_rdate option:selected").val();
        var driver =  $("#d_cd option:selected").val();
        var cont_person =  $("#d_cp option:selected").val();
        var trip = $("#search_filter_ts").val();
        var item = $("#d_iname option:selected").val();
        var eqp =  $("#equipment_filter option:selected").val();
        var status  =  $("#d_status option:selected").val();
        //alert(req_date+"/"+driver+"/"+cont_person+"/"+trip+"/"+item+"/"+eqp+"/"+status);
$.post('ajax_for_trip_tbl_body.php',{req_date:req_date,driver:driver,cont_person:cont_person,trip:trip,item:item,eqp:eqp,status:status},function(data){
    //alert(data);
    $('#trip_sheet_tbl_body').html('');
    $('#trip_sheet_tbl_body').html(data);
    $("#ts_refresh_spinner").hide();
      ShowLocalDate();
  });*/
      $.post( "trip_tbl_body.php",{},function(data) {
        $("#trip_sheet_tbl_body").html(data);
        filter_table($("#d_rdate option:selected").val(),
          $("#d_cd option:selected").val(),
          $("#d_cp option:selected").val(),
          $("#search_filter_ts").val(),
          $("#d_iname option:selected").val(),
          $("#equipment_filter option:selected").val(),
          $("#d_status option:selected").val(),
          $("#trip_sheet_tbl_body"));
      $("#ts_refresh_spinner").hide();
      ShowLocalDate();
      });
    }
    else if($("#sel_view option:selected").text()=='Relocation'){
      $("#rl_refresh_spinner").show();
      $.post( "relocation_tbl_body.php",{},function(data) {
            $("#relocation_tbl_body").html(data);
             filter_table($("#rl_d_rdate option:selected").val(),
              $("#rl_d_cd option:selected").val(),
              $("#rl_d_cp option:selected").val(),
              $("#rl_search_filter_ts").val(),
              $("#rl_d_iname option:selected").val(),
              $("#rl_equipment_filter option:selected").val(),
              $("#rl_d_status option:selected").val(),
              $("#relocation_tbl_body"));
      $("#rl_refresh_spinner").hide();
              ShowLocalDate();
      });
    }
      }, 30000); 


     function map_refresh()
      {
    
              $.ajax({
               type: "POST",
               url: "vehicles_.php",
               data: 'fromajax=true',
               cache: false,
               success: function(result)
               {
                 myMapType = map.getMapTypeId();
                savedMapZoom=map.getZoom(); 
                mapCentre=map.getCenter(); 
                mapLat=mapCentre.lat(); 
                mapLng=mapCentre.lng();
                LocationData = $.parseJSON(result); //alert(LocationData);
                if($("#d_map").val()=='')
                {
                  if(imei_arr.length==0)
                  {
                    initialize_both(LocationData,substationData);
                  }
                  else
                  {
                filtered_arr = filter_eqptype(imei_arr,LocationData,21).concat(filter_eqptype(imei_arr,LocationData,20));
                     initialize(filtered_arr);
                if(filtered_arr.length==1)
                     {
                      mapLat= filtered_arr[0][3];
                      mapLng= filtered_arr[0][4];
                }
                  }

                }
                else
                {

                  if(imei_arr.length==0)
                  {
                    //initialize_both(LocationData,substationData);
          
                    var test_arr = new Array();
                    test_arr[0] = $("#d_map").val();
                    initialize_both(filter_veh_search(test_arr[0],LocationData),substationData);
           
                  }
                  else
                  { 
                     filtered_arr = filter_eqptype(imei_arr,LocationData,21).concat(filter_eqptype(imei_arr,LocationData,20));
                     initialize(filtered_arr);
                     if(filtered_arr.length==1)
                     {
                           mapLat= filtered_arr[0][3];
                           mapLng= filtered_arr[0][4];
                     }
                  }


                  if($('#sel_type option:selected').val()=='POI')
                  {
                    var test_arr = new Array();
                    test_arr[0] = $("#d_map").val();
                    filterdata_search = filter_eqptype(test_arr,substationData,1);
                    if(filterdata_search.length>0)
                    {
                             initialize_poi(filterdata_search);
                    }
                  }
                }
               right_click_event(); 
               long_press_zoom();
              map.setCenter(new google.maps.LatLng(mapLat,mapLng));
              map.setZoom(savedMapZoom);
          } //sucess close
               });
      ShowLocalDate();
     }
</script>
<? include 'header.php'; ?> 
<div id="dialogoverlay"></div>
<div id="dialogbox">
  <div>
    <div id="dialogboxhead"></div>
    <div id="dialogboxbody"></div>
    <div id="dialogboxfoot"></div>
  </div>
</div>
<div id='trip_sheet_div' style='display:none;position: fixed; top: 0; right: 0; bottom: 0; left: 0; width: 100%; height: 100%; overflow: auto;
    z-index: 3; padding: 20px; box-sizing: border-box; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.75); text-align: center;'></div>
<div id='view_assets_div' style='display:none;position: fixed; top: 0; right: 0; bottom: 0; left: 0; width: 100%; height: 100%; overflow: auto;
    z-index: 3; padding: 20px; box-sizing: border-box; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.75); text-align: center;'></div>
<div id='camera_his_div' style='display:none;position: fixed; top: 0; right: 0; bottom: 0; left: 0; width: 100%; height: 100%; overflow: auto;
    z-index: 2; padding: 20px; box-sizing: border-box; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.75); text-align: center;'></div>
    

    <div id="dyn_back" title='Back' style="border: 1px solid #B7B2B2;     
  box-shadow: 5px 5px 20px #888888;
    position: absolute;
    left: 0px;
    z-index: 1;
    top: 46px;
    width: 3vw;
    height: 2vw;
    display: none;
    background-image: url('image/back_icon.png');
    background-color: white;
    background-size: 100% 100%;">
      <!-- <input type='button' id='uni_back' value='Back'><br />-->
    </div>
  
<div id='views' style="min-height:70vh;">
  <div class='current_view' id='Map'>
    <div id='piechart' style="display:none;width: 15%; height:200px; position: absolute; z-index: 1; margin-left: 0; margin-top: 50px;"></div>
    <div id="map-canvas" style="width:100%;height:77vh;"></div>
  </div>
  <div class='current_view' id='History' style='display:none;'></div>
  <div class='current_view' id='Board' style='display:none;'></div>
  <div class='current_view' id='Repair_Request' style='display:none;'></div>
  <div class='current_view' id='Reports' style='display:none;'></div>
  <div class='current_view' id='Equipment_Security' style='display:none;'></div>
  <div class='current_view' id='Manage_POI' style='display:none;'></div>
  <div class='current_view' id='Schedule' style='display:none;'></div>
  <div class='current_view' id='Admin' style='display:none;'></div>
  <div class='current_view' id='Tracker_Location' style='display:none;'></div>
  <div class='current_view' id='Trip_Sheet' style='display:none;'></div>
  <div class='current_view' id='Relocation' style='display:none;'></div>
  <div class='current_view' id='Activity_Search' style='display:none;'></div>
  <div class='current_view' id='Dispatch' style='display:none;'></div>
  <div class='current_view' id='sch_cal' ></div>
</div>
<? include 'fotter.php'; ?>   



