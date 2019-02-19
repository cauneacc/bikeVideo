<?php

class SaveDbConfigurationToFileCommand extends CConsoleCommand{

	public function run($args){
		Configuration::saveConfigurationToFile();
	}

}
?>
