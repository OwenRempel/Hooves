import { useEffect, useState } from 'react';

import Back from '../../Back'
import Table from '../../Table/Table';

function CowsList() {
    const [AllCows, setAllCows] = useState({});
    useEffect(() => {
      fetch(process.env.REACT_APP_API_URL+'/cattle?token='+localStorage.getItem('Token'))
            .then(response => response.json())
            .then(result => {
              setAllCows(result)
            })
    }, []);
    return (
        <div>
            <Back link='/'/>
            <h1>All Cattle</h1>
            {AllCows.Data &&
               <Table stick={true} table={AllCows} UrlKey={[{title:'View',link:'/cows/', className:'btn btn-small'}]}/>
            }
            
        </div>
    )
}

export default CowsList
