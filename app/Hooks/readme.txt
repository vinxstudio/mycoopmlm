hook functions declared here will be called while distributing the Pairing income.

example:


function yourHookFunction($accountObject, $totalPairsForToday, $currentLevel, $incomeObject){

}

Please be noted that the parameters are required for your custom function to have.

for your hooks to be registered, put them in config/pairingHooks.php ->hooks array;