
//lib
isset = function(obj) {
  var i, max_i;
  if(obj === undefined) return false;
  for (i = 1, max_i = arguments.length; i < max_i; i++) {
    if (obj[arguments[i]] === undefined) {
        return false;
    }
    obj = obj[arguments[i]];
  }
  return true;
};


// JS FOR DOWNLOAD
var nbPackagesToLoad=0;
var nbPackagesLoaded=0;

function downloadPackage(packagename)
{
	var params='packagename='+packagename;

	$.ajax({
				async: "true",
				type: "post",
				url: "deploy.php?ajax=downloadpackage",
				data: params,

				error: function(errorData) { $("#ajaxresults").html(errorData); },

				success: function(data) {
							$("#ajaxresults").html(data);
							
							sendFlagPackageIsLoaded();
							
							if(data == "Error")
							{
								$("#ajaxerrors").html($("#ajaxerrors").html()+"<div class='ajaxerror'><div>Warning : Download Error for "+packagename+" - check download src links or package name.</div><div>If this package is not an important one, you can continue the deployment below.</div></div><br />");
							}
						}

		});
}


function sendFlagPackageIsLoaded()
{
	if(nbPackagesToLoad>0)
	{
		$("#loadedbar").width($("#loadedbar").width()+($("#loadingbar").width()/nbPackagesToLoad));
		nbPackagesLoaded++;
	}
	
	if(nbPackagesLoaded>=nbPackagesToLoad)
	{
		$("#loadedbar").width($("#loadingbar").width());
		$("#buttontocontinue").prop("disabled",false);
		$("#buttontocontinue").css({ opacity: 1 });
		$("#ajaxresults").html("End donwload");
	}
}


function disableButtonToContinue()
{
	$("#buttontocontinue").prop("disabled",true);
	$("#buttontocontinue").css({ opacity: 0.2 });
}



// JS FOR DEPLOY

var nbPackagesToDeploy=0;
var nbPackagesDeployed=0;

var tabPackagesToDeployInOrder=new Array();

function deployPackage(packagename)
{
	var params='packagename='+packagename;

	$.ajax({
				async: "true",
				type: "post",
				url: "deploy.php?ajax=deploypackage",
				data: params,

				error: function(errorData) { $("#ajaxresults").html(errorData); },

				success: function(data) {
							$("#ajaxresults").html($("#ajaxresults").html()+data);
							
							$('#ajaxresults').scrollTop($("#ajaxresults").prop('scrollHeight'));

							sendFlagPackageIsDeployed();
							
							//next deploy (order needed for initer construct)
							var indexcour = tabPackagesToDeployInOrder.indexOf(packagename);
							indexcour++;
							if(isset(tabPackagesToDeployInOrder[indexcour]))
								deployPackage(tabPackagesToDeployInOrder[indexcour]);
						}

		});
	
}

function sendFlagPackageIsDeployed()
{
	if(nbPackagesToDeploy>0)
	{
		$("#loadedbar").width($("#loadedbar").width()+($("#loadingbar").width()/nbPackagesToDeploy));
		nbPackagesDeployed++;
	}
	
	if(nbPackagesDeployed>=nbPackagesToDeploy)
	{
		$("#loadedbar").width($("#loadingbar").width());
		$("#enddeploymentmessage").attr("display","block");
		$("#enddeploymentmessage").css({ opacity: 1 });
		$("#ajaxresults").html($("#ajaxresults").html()+"End deployment<br /><br /><br /><br /><br /><br />");
		$('#ajaxresults').scrollTop($("#ajaxresults").prop('scrollHeight'));
	}
}

function displayNoneEndMessage()
{
	$("#enddeploymentmessage").attr("display","none");
	$("#enddeploymentmessage").css({ opacity: 0 });
}
