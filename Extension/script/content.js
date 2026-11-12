console.log("Content script begun successfully")

// Below calls background.js via chrome runtime messaging to invoke a data request to the SQL server
chrome.runtime.sendMessage(
    {
        action: "getinfo"
    },
    (response) => 
    {
        if (chrome.runtime.lastError)
        {
            console.error("Extension error:", chrome.runtime.lastError.message);
            return;
        }
        // checks to verify that the request was successful and returns corresponding output
        // learned that === exists in Javascript as well
        if (response && response.status === "success")
        {
            console.log("Result from PHP:", response.result);
        }
        else
        {
            console.error("PHP Error:", response.message);
        }
    }
);