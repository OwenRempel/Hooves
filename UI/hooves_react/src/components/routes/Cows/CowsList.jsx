import { useEffect, useState } from 'react';

import Back from '../../Back'
import Table from '../../Table/Table';

function CowsList() {
    const [AllCows, setAllCows] = useState({});
    let feedlot = 0;
    if(localStorage.getItem('Feedlot')){
       feedlot = parseInt(localStorage.getItem('Feedlot'));
    }
    useEffect(() => {
      let feedlotChoice = '/calves';
      if(feedlot === 1){
        feedlotChoice = '/cattle';
      }
      fetch(process.env.REACT_APP_API_URL+feedlotChoice,{
        headers:{
          'Authorization': 'Bearer '+localStorage.getItem('Token'),
        }
      })
            .then(response => response.json())
            .then(result => {
              setAllCows(result)
            })
    }, [feedlot]);
    return (
        <>
            <Back link='/'/>
            {AllCows.Data &&
            <>
              {!AllCows.Data.Locations &&
                <h1>All Cattle</h1>
              }
              <Table stick={true} table={AllCows} UrlKey={[{title:'View',link:'/cows/', className:'btn btn-small'}]}/>
            </>
            }
            
        </>
    )
}

export default CowsList
