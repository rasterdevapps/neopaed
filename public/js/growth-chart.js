function getMarginproperty() {

	var marginProperty ;

	var windowWidth = $(window).width();

	if(windowWidth >= 1280 ) {
		    //window size greater than 1280

          marginProperty =  JSON.parse('{ "marginRight":70, "marginBottom":20, "marginLeft":30,"marginTop":0}');

	} else if(windowWidth < 1280 && windowWidth >= 960) {
		    //window size less than 1280 and greater than 960
		 marginProperty =  JSON.parse('{ "marginRight":70, "marginBottom":20, "marginLeft":30,"marginTop":0}');

	} else if(windowWidth < 960 && windowWidth >= 860) {
		    //window size less than 1280 and greater than 960
		 marginProperty =  JSON.parse('{ "marginRight":40, "marginBottom":15, "marginLeft":20,"marginTop":0}');

	} else if(windowWidth < 860 && windowWidth >= 768) {

         marginProperty =  JSON.parse('{ "marginRight":50, "marginBottom":15, "marginLeft":20,"marginTop":0}');

	} else if(windowWidth < 768 && windowWidth >= 700) {

         marginProperty =  JSON.parse('{ "marginRight":40, "marginBottom":10, "marginLeft":20,"marginTop":0}');

	}  else if(windowWidth < 768 && windowWidth >= 700) {

        marginProperty =  JSON.parse('{ "marginRight":40, "marginBottom":10, "marginLeft":20,"marginTop":0}');

	} else {
		marginProperty =  JSON.parse('{ "marginRight":40, "marginBottom":10, "marginLeft":20,"marginTop":0}');

	}



	return marginProperty;
}

function getBulletSize() {

	var windowWidth = $(window).width();

	    if(windowWidth < 320 ) {

	         bulletSize = 1;

		} else if(windowWidth > 320 && windowWidth <= 480) {

			 bulletSize = 2;

		} else if(windowWidth > 481 && windowWidth <= 780) {

			 bulletSize = 5;

		} else if(windowWidth > 781 && windowWidth  <= 1024) {

	         bulletSize = 4;

		} else if(windowWidth > 1025 && windowWidth <= 1223) {

	         bulletSize = 5;

		}  else if(windowWidth > 1224 && windowWidth < 1824) {

	         bulletSize = 6;

		} else {

			 bulletSize = 7;

		}

    return bulletSize; 
} 


function printPage(elementId) {
    var styleContent = document.getElementById('print_style');
    var windowUrl = 'about:growthcharts';
    var uniqueName = new Date();
    var innerstyle = document.getElementById('inner-style');
        innerstyle.innerHTML = styleContent.value; 
                
    setTimeout(function() {

        var windowName = 'Print' + uniqueName.getTime();
        var printWindow = window.open("text/html", windowName, 'left=50000,top=50000,width=0,height=0');
	    var printContent = document.getElementById(elementId);
	    var content = printContent.innerHTML;

	    printWindow.document.write(content);
        printWindow.document.close();

        printWindow.focus();
        printWindow.print();
        printWindow.close();
        innerstyle.innerHTML = '';

        location.reload();

    }, 1000); 
}
