var showmaps_x = 0;
function showmaps()
{
	if(showmaps_x == 0){
		document.getElementById("jobs_mapdiv").style.display="";
		showmaps_x = 1;
	}else{
		document.getElementById("jobs_mapdiv").style.display="none";
		showmaps_x = 0;
	}
}