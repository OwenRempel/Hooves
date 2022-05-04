import { useState } from "react"
import { Link } from "react-router-dom"

function AllSettings() {
    const [FeedlotButtonTitle, setFeedlotButtonTitle] = useState(localStorage.getItem('Feedlot'))
    
    const handleFeedlotSwitch = (e) => {
        let currentFeedlot = localStorage.getItem('Feedlot');
        if(!currentFeedlot){
            localStorage.setItem('Feedlot', 1)
            setFeedlotButtonTitle(1)
        }
        let FeedlotSwitch;
        if(parseInt(currentFeedlot) === 1){
            FeedlotSwitch = 0
        }else{
            FeedlotSwitch = 1
        }

        fetch(process.env.REACT_APP_API_URL+'/settings/feedlot-set', {
            method:'POST',
            body:JSON.stringify({
                SettingsMod:1,
                Feedlot:FeedlotSwitch
            }),
            headers:{
                'Authorization': 'Bearer '+localStorage.getItem('Token'),
            }
        }).then(response => response.json())
        .then(result => {
          if(result.success){
            localStorage.setItem('Feedlot', FeedlotSwitch)
            setFeedlotButtonTitle(FeedlotSwitch)
          }else{
              console.log(result)
          }
        });
        //TODO: Make sure the user knows what they are clicking on when the click this button

    }
    
    return (
        <>
            <h1>All settings</h1>
            <span>
                <Link to='/settings/pens' className="btn">Pens</Link>
                <Link to='/settings/view-items' className="btn">Display Items</Link>
            </span>
            <div className="allSettingsBlock">
            <br></br>
            <hr/>
                <h2>Site Wide Settings</h2>
                
                <button className={`btn ${(FeedlotButtonTitle && parseInt(FeedlotButtonTitle) === 1 ? 'no-btn' : 'yes-btn')} `} onClick={handleFeedlotSwitch}>{(FeedlotButtonTitle && parseInt(FeedlotButtonTitle) === 1 ? 'Turn Off Feedlot Mode' : 'Turn On Feedlot Mode')}</button>
            </div>
        </>
    )
}

export default AllSettings
