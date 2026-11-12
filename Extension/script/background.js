// background.js is used as a service worker to call information from the SQL server
// Code is executed when a ping is sent from content.js
chrome.runtime.onMessage.addListener((request, sender, sendResponse) =>
{
    // Gets information from extension-endpoint.php with the specified directions below
    fetch("http://localhost/Filtergana/Filtergana/extension-endpoint.php",
    {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(request)
    })

    // with the returned information the script will try to interpret it:
    .then((response) => response.text())
    .then((text) => 
    {
        try 
        {
            // data is parsed in JSON formatting
            const data = JSON.parse(text);
            sendResponse(data);
        }
        catch (error)
        {
            // error/logging snippet
            // Used for debugging, should not be really used later on but will remain in script just in case 
            console.error("RAW OUTPUT: ", text);
            sendResponse({status: "error", message: error.message});

        }
    })

    // allows for the service worker channel to remain open for later calling by the extension
    return true;
});