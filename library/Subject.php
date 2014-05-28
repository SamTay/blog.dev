<?php

interface Subject {
	function attach(Observer $observer);
	function detach(Observer $observer);
	function getObservers();
	function getState();
	function setState($state);
	function notify();
}