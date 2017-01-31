<?php require_once("netricite/view/vViewInit.php"); ?>   
<?php $this->title = "My website - About" ;
use Netricite\Framework as fw;
?>

	<div class="text">
		<div class="page__filler">
		<h4>About</h4>
		<hr />
		</div>
		
		<div class="page__filler">
		<h2>Application framework</h2>
		<ul>
			<li>Application: <?= fw\fwConfiguration::get('site.application.name')?> - developed by jpguilleron@hotmail.com </li>
			<li>Application: <?= fw\fwConfiguration::get('site.application.name')?> - Version : <?= fw\fwConfiguration::get('site.application.version')?></li>
			<li>Based on Wamp server 2.5  (APache, PHP, MySQL running above Windows) </li>
			<li>PHP version: 5.5.12 </li>
			<li>APACHE version: 2.4.9 </li>
			<li>MySQL version: 5.6.17 </li>
		</ul>
		</div>
		
		<div class="page__filler">
    		<h2>Netricite Application Function</h2>
    		<ul>
    			<li>Blog</li>
    			<li>Chat</li>
    			<li>Shop</li>
    			<li>TODO list</li>
    		</ul>
    		<hr />
    	</div>
		
		
		<div class="page__filler">
		<h2>What brings version - <?= fw\fwConfiguration::get('site.application.version')?></h2>
		
		<ul>User features
			<li>Google maps</li>
			<li>Google signin</li>
			<li>Google recaptcha</li>
		</ul>
		<ul>Technical features
			<li>Parameters centralization</li>
			<li>Form generator</li>
			<li>Page cache</li>
		</ul>
		<hr />
		</div>


		
</div>
<div>Copyright [2017] [netricite]

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.</div>

