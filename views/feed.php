<?php if(!$min) $this->layout('layout/main', ['max' => $max, 'jobs' => $jobs, 'stats' => $stats])?>
<?php if(isset($stats)):?>
<div class="d-none jsStats">
	<span class="jsStatsTotal"><?= $stats['total']?></span> <span
		class="jsStatsSaved"><?= $stats['saved']?></span><span
		class="jsStatsLastH"><?= $stats['lasth']?></span><span
		class="jsStatsLastD"><?= $stats['lastd']?></span><span
		class="jsStatsLastM"><?= $stats['lastm']?></span><span
		class="jsStatsNew"><?= $stats['new']?></span>

</div>
<?php endif;?>
<?php if(count($jobs) || $jobs->count()):?>
<?php

    foreach ($jobs as $job) :
        $date = $job->getPosted();
        ?>
<div
	class="card jsJobCard col-sm-12 border-bottom-0 rounded-0<?php if($min):?> d-none<?php endif;?>"
	data-id="<?php echo $job->getId()?>">
	<div class="row no-gutters">
		<div class="col-md-2">
			<div class="card-body" style="padding: 1.25rem 0 0 0">
				<ul class="list-group list-group-flush">
					<li class="list-group-item border-top-0">
<?php if($job->getBudget()):?>
$<?php echo $job->getBudget()?>
<?php else:?>
Hourly
<?php endif;?>
</li>
					<li class="list-group-item"><span class="badge badge-info"><?php echo $job->getCountry();?></span>
					</li>
					<!-- 						<li class="list-group-item">
<span class="badge badge-info"><?php echo $date->format('Y/m/d H:i');?></span>
</li> -->
					<li class="list-group-item"><small data-toggle="tooltip"
						title="<?php echo $date->format('Y/m/d H:i');?>"
						class="jsPostedInfo"
						data-posted="<?php echo $date->getTimestamp ()?>"
						data-id="<?php echo $job->getId()?>"><div
								class="spinner-grow spinner-grow-sm" role="status">
								<span class="sr-only">Loading...</span>
							</div></small></li>
				</ul>
			</div>
		</div>
		<div class="col-md-10">
			<div class="card-body">
				<div class="float-right">
					<div class="spinner-border text-secondary float-left d-none"
						data-id="<?php echo $job->getId()?>" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<button type="button" class="btn btn-warning btn-sm jsSaveJob"
						data-id="<?php echo $job->getId()?>"
						data-saved="<?php echo $job->getIsSaved() ? 1 : 0?>">
						<span
							class="jsSaved <?php if(!$job->getIsSaved()):?>d-none<?php endif;?>"><i
							class="fas fa-star"></i> UnSave</span> <span
							class="jsUnSaved <?php if($job->getIsSaved()):?>d-none<?php endif;?>"><i
							class="far fa-star"></i> Save</span>
					</button>
					<button type="button" class="btn btn-danger btn-sm jsDeleteJob"
						data-id="<?php echo $job->getId()?>">
						<i class="fas fa-trash-alt"></i> Delete
					</button>
				</div>
				<h5 class="card-title">
					<a href="<?php echo $job->getLink();?>" class="blank"><?php echo html_entity_decode(str_ireplace([' - upwork'], [''], $job->getTitle()))?></a>
				</h5>
				<p class="card-text linkify"><?php echo html_entity_decode($job->getDescription())?></p>
    <?php if($skills = $job->getJobSkills()):?>
    <?php foreach($skills as $skill):?>
    <span class="badge badge-dark"
					data-id="<?php echo $skill->getSkill()->getId()?>"><?php echo $skill->getSkill()->getTitle()?></span>
    <?php endforeach;?>
    <?php endif;?>
  </div>
		</div>
	</div>
</div>
<?php endforeach;?>
<?php endif;?>
