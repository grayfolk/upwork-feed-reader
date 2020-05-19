<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<title>Upwork</title>
<link rel="shortcut icon" type="image/png" href="favicon.ico">
<!-- Bootstrap core CSS -->
<link rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
	crossorigin="anonymous">
<style type="text/css">
body {
	padding-top: 5rem;
	padding-bottom: 5rem;
}

.starter-template {
	padding: 3rem 1.5rem;
	text-align: center;
}
</style>
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" href="/">Upwork</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse"
			data-target="#navbarsExampleDefault"
			aria-controls="navbarsExampleDefault" aria-expanded="false"
			aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="col-sm-1">
			<div class="spinner-border text-secondary d-none jsUpdateInProgress"
				role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
		<span class="navbar-text"> Total: <span
			class="badge badge-secondary jsStatsTotal"><?= $stats['total']?></span>
		</span> <span class="navbar-text ml-3"> Last hour: <span
			class="badge badge-secondary jsStatsLastH jsStatsLastHColor"><?= $stats['lasth']?></span>
		</span> <span class="navbar-text ml-3"> Last day: <span
			class="badge badge-secondary jsStatsLastD"><?= $stats['lastd']?></span>
		</span> <span class="navbar-text ml-3"> Last month: <span
			class="badge badge-secondary jsStatsLastM"><?= $stats['lastm']?></span>
		</span><span class="navbar-text ml-3"> New: <span
			class="badge badge-secondary jsStatsNew"><?= $stats['new']?></span>
		</span>
		<div class="collapse navbar-collapse justify-content-end"
			id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" href="/saved">Saved <span
						class="badge badge-secondary jsStatsSaved"><?= $stats['saved']?></span>
				</a></li>
			</ul>
		</div>
		<span class="jsRestoreJob"></span>
	</nav>

	<main role="main" class="container"> <small data-toggle="tooltip"
		class="--jsPostedInfo" data-posted="<?php echo time()-55?>"
		data-id="9999999"></small>
	<button type="button"
		class="btn btn-secondary btn-lg btn-block mb-2 d-none jsNewJobsApply">
		New Jobs Incoming (<span class="jsNewJobsCount"></span>)
	</button>
	<div class="row jsJobsHolder">
	<?=$this->section('content')?>
	</div>
	<div
		class="alert alert-info jsNoJobsAlert<?php if(!$jobs->count()):?> d-none<?php endif;?>"
		role="alert">
		No jobs right now <span class="float-right">
			<button type="button"
				class="btn btn-primary btn-sm jsForceUpdateJobs">Update</button>
		</span>
	</div>

	</main>
	<!-- /.container -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		crossorigin="anonymous"></script>
	<script
		src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
		integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
		crossorigin="anonymous"></script>
	<script
		src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
		crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/2e270fbffa.js"></script>
	<script
		src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-linkify/2.1.8/linkify.min.js"
		integrity="sha256-b8aRDYEOoOLGpyaXMI3N2nWUbjSeQ2QxzKjmPnCa4yA="
		crossorigin="anonymous"></script>
	<script
		src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-linkify/2.1.8/linkify-jquery.js"
		integrity="sha256-WummesA96UBuZX2euMGXuAd9kJEnri9S+1/WCu1RS+s="
		crossorigin="anonymous"></script>
	<script
		src="https://cdn.jsdelivr.net/npm/favico.js@0.3.10/favico-0.3.10.min.js"
		integrity="sha256-aRour8lyAmi7G9tScowwf13ZdS6wbDwhMCb6o5/oMLA="
		crossorigin="anonymous"></script>
	<script src="/assets/js/cd.js"></script>
	<script src="/assets/js/jquery.hotkeys.js"></script>
	<script>
		let jobId = <?php echo $max?>, favicon, newJobs, jobCount = 0, lastHcount = <?= $stats['lasth']?>, deletedJobs = []

		let audioElement = document.createElement('audio');
	    audioElement.setAttribute('src', '/assets/mp3/jubilation.mp3');
	    audioElement.volume = 0.4;
		
        jQuery(document).ready(function($){
        	$('[data-toggle="tooltip"]').tooltip()
    		favicon = new Favico({
        	    animation:'fade'
        	})
        	setInterval(function(){
            	getJobs()
            }, 10000)
            updateJobs()
        	$('body').on('click', '.jsDeleteJob', function(e){
        		let id = $(this).data('id')
        		$('.spinner-border[data-id='+id+']').removeClass('d-none')
        		$.ajax({
        			type : 'DELETE',
        			url : '/jobs/' + id,
        			success: function(){
        				deletedJobs.unshift(id)
        				$('div.jsJobCard[data-id='+id+']').remove()
        			},
        			complete: function(){
        				// $('div.jsJobCard[data-id='+id+']').remove()
        				$('.spinner-border[data-id='+id+']').addClass('d-none')
        				updateJobs()
        			}
        		});
            }).on('click', '.jsSaveJob', function(e){
                let btn = $(this)
            	let id = btn.data('id')
            	let saved = btn.data('saved')
            	// console.log(saved)
        		$('.spinner-border[data-id='+id+']').removeClass('d-none')
        		$.ajax({
        			type : 'POST',
        			url : '/jobs/' + id,
        			success: function(){
            			/* if(saved == '0'){
            				btn.data('saved', '1')
            				btn.find('.jsSaved').removeClass('d-none')
            				btn.find('.jsUnSaved').addClass('d-none')
                		} else {
                			btn.data('saved', '0')
                			btn.find('.jsSaved').addClass('d-none')
            				btn.find('.jsUnSaved').removeClass('d-none')
                    	} */
        			},
        			complete: function(){
        				if(saved == '0'){
            				btn.data('saved', '1')
            				btn.find('.jsSaved').removeClass('d-none')
            				btn.find('.jsUnSaved').addClass('d-none')
                		} else {
                			btn.data('saved', '0')
                			btn.find('.jsSaved').addClass('d-none')
            				btn.find('.jsUnSaved').removeClass('d-none')
                    	}
        				$('.spinner-border[data-id='+id+']').addClass('d-none')
        				btn.blur()
        			}
        		});
            }).on('click', '.jsRestoreJob', function(e){
                if(!deletedJobs.length) return
                let id = deletedJobs.shift()
        		$('.jsUpdateInProgress').removeClass('d-none')
        		$.ajax({
        			type : 'GET',
        			url : '/jobs/' + id,
        			success: function(data){
        				if(data) {
            				$('.jsJobsHolder').prepend(data)
            				$('div.jsJobCard[data-id='+id+']').removeClass('d-none')
            				countdown()
            				if($('div.jsJobCard').length){
            	        		$('.jsNoJobsAlert').addClass('d-none')
            	        	}
        				}
        			},
        			complete: function(){
        				$('.jsUpdateInProgress').addClass('d-none')
        			}
        		});
            }).on('click', '.jsNewJobsApply', function(e){
            	$(this).addClass('d-none')
            	$('div.jsJobCard').removeClass('d-none')
            }).on('click', '.jsForceUpdateJobs', function(e){
                $('.jsUpdateInProgress').removeClass('d-none')
            	getJobs()
            })
            // Hotkeys
            .on('keydown', null, 'space', function(){
                $('.jsNewJobsApply').trigger('click')
                return false
            })
        	.on('keydown', null, 'f5', function(){
        		$('.jsForceUpdateJobs').trigger('click')
        		return false
            })
        	.on('keydown', null, 'esc', function(){
                $('.jsDeleteJob[data-id='+$('.jsJobCard').not('.d-none').first().data('id')+']').trigger('click')
            })
            .on('keydown', null, 'return', function(){
            	$('.jsRestoreJob').trigger('click')
            })
        })
        function updateJobs(){
	        if(jobCount != $('div.jsJobCard').length){
	        	jobCount = $('div.jsJobCard').length
        		favicon.badge(jobCount)
        	}
	        if(deletedJobs.length > 100){
	        	deletedJobs = deletedJobs.slice(0, 100)
		    }
        	if($('div.jsJobCard').length){
        		$('.jsNoJobsAlert').addClass('d-none')
        	} else {
        		$('.jsNoJobsAlert').removeClass('d-none')
            }
	        $('div.jsJobCard').each(function(){
        		if($(this).data('id') > jobId) jobId = $(this).data('id')
            })
            $('a.blank').attr('target', '_blank')
        	$('.linkify').linkify({
        	    target: "_blank"
        	})
        	// $('.jsUpdateInProgress').addClass('d-none')
        	countdown()
        	// Update stats
        	let s = $('div.jsStats span')
        	if(s.length){
            	s.each(function(){
                	let e = $(this).attr('class')
                	let c = $(this).text()
                	$('.' + e).text(c)
                	if(e == 'jsStatsLastH'){
                    	//console.info('jsStatsLastH')
                    	let cp = parseInt(c, 10)
                    	
                		if(lastHcount > cp){
                			//console.info('lastHcount > cp')
                			$('.jsStatsLastHColor').removeClass('badge-primary badge-secondary badge-success badge-danger badge-warning badge-info badge-light badge-dark')
                    		if(lastHcount - cp > 3) $('.jsStatsLastHColor').addClass('badge-danger')
                    		else $('.jsStatsLastHColor').addClass('badge-warning')
                    	}
                		if(lastHcount < cp){
                			//console.info('lastHcount < cp')
                			$('.jsStatsLastHColor').removeClass('badge-primary badge-secondary badge-success badge-danger badge-warning badge-info badge-light badge-dark')
                			if(cp - lastHcount > 3) $('.jsStatsLastHColor').addClass('badge-success')
                    		else $('.jsStatsLastHColor').addClass('badge-info')
                    	}
                		if(lastHcount == cp){
                			//console.info('lastHcount == cp')
                			// $('.jsStatsLastHColor').removeClass('badge-primary badge-secondary badge-success badge-danger badge-warning badge-info badge-light badge-dark')
                			// $('.jsStatsLastHColor').addClass('badge-secondary')
                    	}

                		lastHcount = cp
                    }
                })
            }
        }
        function getJobs(){
        	$('.jsUpdateInProgress').removeClass('d-none')
        	$.ajax({
    			type : 'GET',
    			url : '/jobs?id=' + jobId,
    			success: function(data){
    				$('div.jsStats').remove()
        			if(data) {
        				$('.jsJobsHolder').prepend(data)
        				if($('div.jsJobCard.d-none').length) {
            				$('.jsNewJobsApply').removeClass('d-none')
            				$('.jsNewJobsCount').text($('div.jsJobCard.d-none').length)
        				}
        				updateJobs()
            		}
    			},
    			complete: function(){
    				// updateJobs()
    				$('.jsUpdateInProgress').addClass('d-none')
    			}
    		});
        }
	</script>
</body>
</html>
