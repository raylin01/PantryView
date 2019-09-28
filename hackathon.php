<html>
<?php include("header.php")?>

<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>

 <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

<style>
	* {
		font-family: 'Roboto', sans-serif;
		transition: 0.3s;
	}

	body {
		margin: 0;
		background: #FFFEF7;
	}

	.hidden {
		display: none;
	}

	.header {
		position: relative;
		margin-bottom: 20px;
		width: 100%;
		height: 50px;
		background: black;
	}

	.search-box {
		position: relative;
		width: 300px;
		height: 150px;
		margin: auto;
		background: #ccc;
		/*z-index: 999;*/
	}

	.body-content {
		position: relative;
		width: calc(100% - 80px);
		margin: auto;
		margin-top: 30px;
	}

		.body-content .item {
			position: relative;
			width: calc(100% - 62px);
			padding: 20px 30px;
			border: solid 1px #ccc;
			/*overflow: auto;*/
		}

			.body-content .item:hover {
				background: rgba(0,0,0,0.04);
				cursor: pointer;
			}

			.body-content .item h1 {
				color: #234EB0;
			}

			.body-content .item .left-box {
				/*float: left;*/
			}

				.body-content .item .left-box h2 {
					font-size: 20px;
					color: #666;
				}

			.body-content .item .right-box {
				position: absolute;
				height: 100%;
				right: 0;
				width: 20px;
				top: 0;
			}

			.body-content .item .right-box h2 {
				position: absolute;
				right: 30px;
				top: 0;
				bottom: 0;
				height: 24px;
				margin: auto;
				width: 200px;
				text-align: right;
			}

	.popup-drop {
		position: fixed;
		width: 100%;
		height: 100%;
		top: 0;
		background: rgba(0,0,0,0.3);
	}

	.popup {
		position: fixed;
		width: 70%;
		height: fit-content;
		margin: auto;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		background: #FFFEF7;
		/*display: none;*/
		z-index: 10;
		top: 20px;
		border-radius: 12px;
		box-shadow:rgba(0, 0, 0, 0.3) 0px 5px 10px 0px;
		max-height: calc(100% - 50px);
		overflow: auto;
	}

		.popup-body {
			width: calc(100% - 40px);
			max-height: calc(100% - 50px);
			padding: 20px;
			margin: 0;
			border: solid 1px #ccc;
			overflow: auto;
			border-radius: 12px;
		}

			.popup-body .top-section {
				margin-bottom: 30px;
				width: 100%;
				text-align: center;
			}

				.popup-body .top-section h1 {
					font-size: 35px;
				}

				.popup-body .top-section h2 {
					font-weight: 300;
					color: #333;
					font-size: 18px;
				}

			.popup-body .desc {
				margin-bottom: 25px;
				border-bottom: solid 1px #ccc;
			}

				.popup-body .desc p {
					font-size: 20px;
					font-weight: 200;
					margin-bottom: 45px;
				}

			.popup-body .left-side {
				float: left;
				width: calc(50% - 65px);
				margin-left: 45px;
			}

			.popup-body .right-side {
				float: right;
				width: calc(40% - 20px);
				text-align: left;
			}

	.loading-screen {
		position: fixed;
		width: 100%;
		height: 100%;
		top: 0;
		background: #FFFEF7;
	}

		.loading-screen .loading-text {
			position: absolute;
			top: 20%;
			width: fit-content;
			height: fit-content;
			margin: auto;
			left: 0;
			right: 0;
		}

			.loading-screen .loading-text {
				text-align: center;
			}

		.loading-screen .endevre {
			position: absolute;
			margin: auto;
			width: 250px;
			height: 150px;
			/*background: #333;*/
			top: 55%;
			left: 0;
			right: 0;
			/*opacity: 0;*/
		}

			.loading-screen .endevre h1 {
				text-align: center;
				font-size: 20px;
				color: #666;
			}

			.loading-screen .endevre .logo {
				background: url("https://www.endevre.com/assets/img/endevre_logo_main_bold5.svg");
				width: 180px;
			    height: 50px;
			    background-size: contain;
			    background-repeat: no-repeat;
			    margin: auto;
			}
</style>

<div class="header"></div>

<div id="item1" class="body-content">
	

</div>

<div class="popup-drop hidden" onclick="closePopup()"></div>

<div class="popup hidden">
	<div class="popup-body">
		<div class="top-section">
			<h1 id="name">name</h1>
			<h2 id="address">address</h2>
		</div>
		<div class="desc">
			<p id="desc">description</p>
		</div>
		<div class="left-side">
			<h3 id="fees">fees</h3>
			<h3 id="area">area served</h3>
			<h3 id="docs">documents needed</h3>
			<h3 id="hours">hours</h3>
			<h3 id="ref">referral procedures</h3>
			<h3 id="services">services</h3>
		</div>
		<div class="right-side">
			<h2 style="text-decoration: underline;">Contact Us</h2>
			<div id="phone"></div>
			<div id="web"></div>
		</div>
	</div>
</div>

<div class="loading-screen">
	<div class="loading-text">
		<h1>Loading...</h1>
		<h2>Please Wait</h2>
		<img src="https://www.traveldailymedia.com/wp-content/themes/publisher-child/tdjobs/assets/loader.gif" style="width: 50px; height: 50px">
	</div>
	<div class="endevre">
		<h1>Powered by</h1>
		<div class="logo"></div>
	</div>
</div>

<script>
var data;

var ourRequest = new XMLHttpRequest();
ourRequest.open('POST', "foodpantry.json");
ourRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
ourRequest.onload = function() {
	console.log(ourRequest.responseText);
	var myData = JSON.parse(ourRequest.responseText);
	console.log(myData);

	data = myData;
	
	for (let i in myData) {
		$('.body-content').append(
			'<div class="item" onclick="openPopup(' + i + ')">' +
				'<div class="left-box">' +
					'<h1>' + myData[i].name + '</h1>' +
					'<h2>' + myData[i].address + '</h2>' +
				'</div>' +
				'<div class="right-box">' +
					'<h2>More Info</h2>' +
				'</div>' +
			'</div>'
		);
	}

	setTimeout(function() {
		$('.loading-screen').css("opacity", "0");
		setTimeout(function() { $('.loading-screen').addClass("hidden"); }, 1000);
	}, 3000);
}
ourRequest.send();

function openPopup(index) {
	$('#name').html(data[index].name);
	$('#address').html(data[index].address);
	$('#desc').html("\t" + data[index].description);
	$('#fees').html("Fees: " + data[index].fees);
	$('#area').html("Area Served: " + data[index]["area served"]);
	$('#docs').html("Documents Needed: " + data[index]["documents needed"]);
	$('#hours').html("Hours: " + data[index].hours);
	$('#ref').html("Referral Procedures: " + data[index]["referral procedures"]);
	$('#services').html("Services: " + data[index].services);

	$('#phone').html("");
	$('#web').html("");
	for (let i in data[index].phone) {
		$('#phone').append('<h3>' + data[index].phone[i].number + "  <span style='color: rgba(0,0,0,0.5); font-size: 15px'>" + data[index].phone[i].type + '</span></h3>');
	}
	for (let i in data[index].web) {
		$('#web').append('<h3>' + data[index].web[i].link + "  <span style='color: rgba(0,0,0,0.5); font-size: 15px'>" + data[index].web[i].type + '</span></h3>');
	}

	$('.popup').removeClass("hidden");
	$('.popup-drop').removeClass("hidden");
}

function closePopup() {
	$('.popup').addClass("hidden");
	$('.popup-drop').addClass("hidden");
}
</script>

</html>