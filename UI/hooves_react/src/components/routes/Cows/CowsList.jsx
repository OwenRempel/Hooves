import { useEffect, useState } from 'react';

import Back from '../../Back'
import Table from '../../Table/Table';

function CowsList() {
    const [AllCows, setAllCows] = useState({});
    const [GroupOptions, setGroupOptions] = useState([])
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
   
    const handleGroupSelect = (e) => {
      if(e.target.checked){
        setGroupOptions([...GroupOptions, e.target.value])
      }else{
         setGroupOptions(GroupOptions.filter(id =>id !== e.target.value))
      }
    }

    const groupDelete = () => {
      console.log('Selected Cows Have Been deleted');
      setGroupOptions([]);
    }
    return (
        <>
            <Back link='/'/>
            {AllCows.Data &&
            <>
              {!AllCows.Data.Locations &&
                <h1>All Cattle</h1>
              }
              {GroupOptions.length !== 0 &&
                <div className='groupOptionsDiv'>
                  <h3>Actions for selected items</h3>
                  <button className='btn no-btn btn-small' onClick={groupDelete}>Delete</button>
                  <button className='btn btn-small'>Move</button>
                  <button className='btn btn-small'>Add to Group</button>
                </div>
              }
              <Table stick={true} table={AllCows} UrlKey={[{title:'View',link:'/cows/', className:'btn btn-small'}]} groupSelect={true} groupList={GroupOptions} groupOnChange={handleGroupSelect}/>
            </>
            }
            
        </>
    )
}

export default CowsList
