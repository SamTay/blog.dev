<?php

interface Observer {
	function update(Subject $subject);
}