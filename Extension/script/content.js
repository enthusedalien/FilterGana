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
            // write the initial list of known words to filter out
            console.log("Result from PHP Query: ", response.result);
            
            // split the above data into resective lists for Kanji and Furigana
            const filteredkanji = response.result.map(item => item.kanji);
            const filteredFurigana = response.result.map(item => item.furigana);
            
            // Call the filter function
            filterpage(filteredkanji, filteredFurigana);
        }
        else
        {
            console.error("PHP Error:", response.message);
            return -1
        }
    }
);

// The main function that makes the furigana application work on browsers.
function filterpage(kanji, furigana)
{
    // Gets an array of every ruby tag in the webpage
    const webRuby = document.querySelectorAll('ruby');
    
    // checks to make sure that ruby elements do exist in the page, else end the application early
    if (webRuby.length > 0)
    {
        // create two arrays to contain the seperated Kanji/Ruby text and 
        // Furigana/rt text
        const RubyTextArray = [];
        const rtTextArray = [];
        
        // report the found ruby tags to the console
        console.log("Found Kanji/Furigana:", webRuby)

        // populate the above arrays.
        webRuby.forEach(ruby => 
        {
            const localRuby = ruby.cloneNode(true); 
            localRuby.querySelectorAll('rt, rp').forEach(el => el.remove());
            
            const baseText = localRuby.textContent.trim();
            RubyTextArray.push(baseText);

            const rtText = Array.from(ruby.querySelectorAll('rt'))
                .map(rt => rt.textContent.trim())
                .join('');
            rtTextArray.push(rtText);
        });

        // verifies that both Ruby and RT arrays are equal in size as a catch to ensure problems 
        // don't arise later on since these arrays are used in parrallel to each other
        if (RubyTextArray.length !== rtTextArray.length)
        {
            console.log("Length of arrays do not match, ending Filtergana process");
            return -2;
        }
        
        // Create an array to track indexes of matched kanji and filtergana to the ruby text from 
        // webRuby
        const indexWebArray = [];
        console.log("Sorted list of found Ruby elements; Starting filtering process...")
        
        // for loop to interate through the Ruby text and locate any matches to the known entries
        // from the imported SQL database
        for (let i = 0; i < RubyTextArray.length; i++)
        {
            // Another array to track the indexes of which kanji match the ruby text
            const filterIndexArray = [];

            // when the below loop finds a match, it pushes the filterlist index found to the 
            // above array where it is called soon after this loop
            for (let j = 0; j < kanji.length; j++)
            {
                if (kanji[j].includes(RubyTextArray[i]))
                {
                    filterIndexArray.push(j);
                }

            }

            // checks that there was an index pushed to the array before executing the code
            if (filterIndexArray > 0)
            {
                // checks to make sure that the ruby text that Filtergana is preparing to remove
                // this extra loop is used as a second check to ensure that two entries of the same
                // Kanji within the known words list that contain different furigana still are verified
                // to ensure there is no mismatch within validation of kanji/furigana pairs. 
                for (let j = 0; j < furigana.length; j++)
                {
                    if (rtTextArray[i].includes(furigana[j]))
                    {
                        indexWebArray.push(i);
                    }
                }
            }
        }

        // checks to make sure that there is a ruby element that is going to be removed
        if (!indexWebArray.length > 0)
        {
            console.log("No Filtered matches found, ending Filtergana process");
            return -3;
        }

        // outputs the indexes of ruby tags that have their furigana filtered out
        console.log("Matches found at sortedRuby index numbers:", indexWebArray, "Removing Furigana...");

        // filters out the furigana from the specified ruby elements.
        for (let i = 0; i < indexWebArray.length; i++)
        {
            const changedRuby = webRuby[indexWebArray[i]];

            console.log("Removing Furigana from Ruby tag indexed", indexWebArray[i])

            changedRuby.querySelectorAll('rt, rp').forEach(el => el.remove());
        }
    }
    else
    {
        console.log("No Ruby-tagged Kanji found.");
        return -1;
    }
}