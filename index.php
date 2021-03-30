<html lang="en">
    <head>
        <title>User Details</title>
        <script type="text/javascript"src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <style>
            table {
                margin: 0 auto;
                 table-layout: fixed;}
            h2{padding-bottom: 15px;
                padding-left: 10px;
                font-size:18px;
                margin:0px;
            }
            .filter1 label{
                font-size:18px;
                padding-bottom: 15px;
            }
            p {
            display: none;
        }
            h1 {padding-left: 20px;
                text-align: left;
                color: #black;
                font-size: xx-large;
                margin:0px;
                font-family: 'Gill Sans', 'Gill Sans MT', ' Calibri', 'Trebuchet MS', 'sans-serif';
            }
            table, th, td {
                
                text-align: left;
                border-collapse: collapse;
                padding: 20px;
            }
            td{
                white-space: nowrap; 
  width: 50px; 
  overflow: hidden;
  text-overflow: ellipsis;
            }
            th{
                background: #e6e6e6;
            }
            section{
                padding:0px 30px;
            }
            .filter {
                display: inline;
                float: left;
                width: 55%;
                padding: 10px;
                margin-bottom: 25px;
            }
            .filter1 {
                display: inline;
                float: right;
                width: 35%;
                padding: 10px;
            }
            .pagination{

                flex: 0 0 65%;
                
           }.pagination label{
            display: inline;
           }
           .button{
            text-align: right;
            flex: 1;
           }
           .content{
            margin-bottom: 30px;
            display: flex;
            padding-bottom: 30px;
            padding: 0px 20px;
        }
            .flex{
                display: flex;
            }
            .align-center{
                align-items: center;
            }
            tr:nth-child(odd) {
                background-color: #f3f3f3;
            }
            label{
                padding: 5px;
                display:block;
            }
            input{
                border: none;
                border-bottom: 1px solid black;
            }
            .filter1 input:focus{
                border-bottom: 1px solid black;
                outline: none;
            }
            .Data{
                margin-top:20px;
                width: 100%;
            }
            
           input#gfg {
           width: 100%;padding-right: 10px;
           }
           .sr{
            display:none;
           }
           td:nth-child(1){
           display: none
           }
           .container {
             border: 10px solid #f1f1f1;
            }
            .contentheader{
                padding:20px;
            }
            img {
            height: 20px;
            }
            .button button {
            border: none;
            background: none;
            }
            input#currPageNo {
           text-align: center;
           width: 50;
           }
           input#currPageNo:focus,input#PageSize:focus{
            outline: none;
           }
           .filter input:checked ~ #smallChk {
            background-color:grey;
           }
           @media only screen and (max-width: 768px){
            td,th{
                
            }
        }
        .menu-bar {
         float: right;
         margin-top: -40px;
         padding: 20px;
            }
            #smallChk > input:active {
                background-color: grey;

            }
             
                

        </style>
    </head>
    <body>
        <div class="container">
        <div class="contentheader">
            <h1>Filter <span style="color: #e0e0e0;">airports</span></h1>
            <div class="menu-bar"><img src="menu.png" class="menu"></div>
            <div class="filter align-center">
                <h2>Type</h2>
                
                <label for="smallChk" style="display: inline;"><input onchange="filterme('small', 'smallChk')" id="smallChk" type="checkbox" name="typecat" value="small">Small</label>
                <label for="mediumChk" style="display: inline;"><input onchange="filterme('medium', 'mediumChk')" id="mediumChk" type="checkbox" name="typecat" value="medium">Medium</label>
                <label for="largeChk" style="display: inline;"><input onchange="filterme('large', 'largeChk')" id="largeChk" type="checkbox" name="typecat" value="large" style="background-color: blue;">Large</label>
                <label for="heliportChk" style="display: inline;"><input onchange="filterme('heliport', 'heliportChk')" id="heliportChk" type="checkbox" name="typecat" value="heliport">Heliport</label>
                <label for="closedChk" style="display: inline;"><input onchange="filterme('closed', 'closedChk')" id="closedChk" type="checkbox" name="typecat" value="closed">Closed</label>
                <label for="favoriteChk" style="display: inline;"><input onchange="filterme('favorite', 'favoriteChk')" id="favoriteChk" type="checkbox" name="typecat" value="favorite">In your favorties</label>
            </div>
            <div class="filter1" >
                <label for="FilterBySearch">Filter By search : </label><input id="gfg" name="FilterBySearch" type="text" placeholder="Search here" /></label>
            </div>
        </div>
        
        <section>
            <table class="Data" >
                <tr>
                    <th class="sr">Sr</th>
                    <th>Name</th>
                    <th>ICAO</th>
                    <th>IATA</th>
                    <th>Elev.</th>
                    <th>Lat.</th>
                    <th>Long.</th>
                    <th>Type</th>
                </tr>
                <tbody id='table'>
                </tbody>
            </table>
        </section>
        <p style"clearfix:all;">&nbsp;</p>
        
        <div class="load"><h4 id="resultHSpan" style="text-align:center;">Loading ...</h4></div>
        <div class="content">
            <div class="pagination" >
                <label for="PageSize">Page Size : <input id="PageSize" type="text" placeholder="Page Size" value="4" /></label>
            </div>
            <div class="button" >
                <label for="currPageNo"><button onclick="previousPage();"><img src="left-arrow.png"></button><input id="currPageNo" type="text" placeholder="Page No" value="1" /><button onclick="nextPage();"><img src="right-arrow.png"></button></label>
            </div>
        </div>
   
        </div>

        <script type="text/javascript">
        
            var _totRecords = 0;
            var _pageSize = 0;
            var recordStart = 0;
            var totalMaxPageCount = 0;
            var pageNo = 0;
            var origRecords = [];
            var displayRecords = [];
            
            $(document).ready(function () {
                getJsonFileData();
			});
			
			function getJsonFileData () {
			    $.getJSON('./airports.json',function (data) {
			        origRecords = data;
			        displayRecords = data;
			        drawCurrTable();
				});
			}
			
			function drawCurrTable() {
			    displayRecords = origRecords;
			    if (($('#currPageNo').val()) == null || typeof($('#currPageNo').val()) == 'undefined' || isNaN(($('#currPageNo').val())) || $('#currPageNo').val().toString().trim().length <= 0) {
			        alert('Please enter valid Page No');
			    } else if (($('#PageSize').val()) == null || typeof($('#PageSize').val()) == 'undefined' || isNaN(($('#PageSize').val())) || $('#PageSize').val().toString().trim().length <= 0) {
			        alert('Please enter valid Page Size');
			    } else { 
    			    var searchString = $("#gfg").val();
    			    if (searchString == null || typeof(searchString) == "undefined" || searchString.toString().trim().length < 3) { searchString = ""; } else { searchString = searchString.toString().trim().toLowerCase(); }
    			    if (searchString.length > 0) {
    			        displayRecords = displayRecords.filter(function (el) {
        			        return (el.name.toString().trim().toLowerCase().includes(searchString.toString()) || el.icao.toString().trim().toLowerCase().includes(searchString.toString()));
        		        });
    			    }
    			    pageNo = parseInt($('#currPageNo').val());
    			    _pageSize = parseInt($('#PageSize').val());
    			    if (pageNo <= 1) { pageNo = 1; $('#currPageNo').val('1'); } pageNo--;
    			    $('#resultHSpan').html("Loading ...");
    			    $('#table').html('');
    			    var rdChk = ($('input[name=typecat]:checked').val());
    			    if (rdChk == null || typeof(rdChk) == "undefined" || rdChk.toString().trim().length <= 0) {} else {
        			    displayRecords = displayRecords.filter(function (el) {
        			        return (el.type.toString().trim().toLowerCase().includes(rdChk));
        		        });
    			    }
    		        var loopTill = Math.ceil((((pageNo * _pageSize) + _pageSize) > displayRecords.length) ? displayRecords.length : ((pageNo * _pageSize) + _pageSize));
    		        totalMaxPageCount = Math.floor(displayRecords.length / _pageSize);
    		        if (totalMaxPageCount < pageNo) { pageNo = totalMaxPageCount; $('#currPageNo').val(totalMaxPageCount.toString()); }
    			    recordStart = (pageNo * _pageSize);
    			    _totRecords = displayRecords.length;
    			    var _html = '';
    		        for (var i = recordStart; i < loopTill; i++) {
    				    _html += '<tr>';
    				    _html += '<td>' + (i+1) +'</td>';
    				    _html += '<td>' + displayRecords[i].name+'</td>';
    				    _html += '<td>' + displayRecords[i].icao + '</td>';
    				    _html += '<td>' + displayRecords[i].iata + '</td>';
    				    _html += '<td>' + displayRecords[i].elevation + '</td>';
    				    _html += '<td>' + displayRecords[i].latitude + '</td>';
    				    _html += '<td>' + displayRecords[i].longitude + '</td>';
    				    _html += '<td>' + displayRecords[i].type + '</td>';
    				    _html += '</tr>';
    		        }
    				$('#table').html(_html);
    				$('#resultHSpan').html('Showing ' + ((_totRecords <= _pageSize) ? (_totRecords) : (_pageSize)).toString() + ' out of ' + _totRecords.toString() + ' (from ' + (recordStart + 1).toString() + ' to ' + (loopTill).toString() + ')');
			    }
			}
			
			function previousPage() {
			    if (($('#currPageNo').val()) == null || typeof($('#currPageNo').val()) == 'undefined' || isNaN(($('#currPageNo').val())) || $('#currPageNo').val().toString().trim().length <= 0) {
			        $('#currPageNo').val('0');
			    } else {
			        $('#currPageNo').val(((parseInt($('#currPageNo').val()) - 1).toString()));
			    }
			    drawCurrTable();
			}
			
			function nextPage() {
			    if (($('#currPageNo').val()) == null || typeof($('#currPageNo').val()) == 'undefined' || isNaN(($('#currPageNo').val())) || $('#currPageNo').val().toString().trim().length <= 0) {
			        $('#currPageNo').val('0');
			    } else {
			        $('#currPageNo').val(((parseInt($('#currPageNo').val()) + 1).toString()));
			    }
			    drawCurrTable();
			}
			
			$(document).ready(function() {
			    $("#gfg").on("keyup", function() {
			        drawCurrTable();
	            });
			    $("#gfg").on("change", function() {
			        drawCurrTable();
	            });
			    $("#PageSize").on("change", function() {
			        drawCurrTable();
	            });
			    $("#currPageNo").on("change", function() {
			        drawCurrTable();
	            });
            });
            
            $(function() {
                otable = $('#table').dataTable();
            });
            
            function filterme(val, id) {
                drawCurrTable();
            }
        </script>
    </body>
</html>