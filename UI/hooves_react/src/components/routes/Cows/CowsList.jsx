import { useEffect, useState } from 'react';

import Back from '../../Back'
import Table from '../../Table/Table';

function CowsList() {
    const [AllCows, setAllCows] = useState({});
    const [GroupOptions, setGroupOptions] = useState([])
    const [GroupSelAction, setGroupAction] = useState(null)
    const [Groups, setGroups] = useState({});
    const [Pens, setPens] = useState({});
    
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
    useEffect(()=> {
      fetch(process.env.REACT_APP_API_URL+"/pens",{
        headers:{
          'Authorization': 'Bearer '+localStorage.getItem('Token'),
        }
      })
            .then(response => response.json())
            .then(result => {
              setPens(result.Data);
            })
    }, []);
    useEffect(()=> {
      fetch(process.env.REACT_APP_API_URL+"/group",{
        headers:{
          'Authorization': 'Bearer '+localStorage.getItem('Token'),
        }
      })
            .then(response => response.json())
            .then(result => {
              setGroups(result.Data);
            })
    }, []);
   
   
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
    const groupAdd = () => {
      setGroupAction('add');
    }
    const groupMove = () => {
      console.log('Move')
    }
    const groupAddCatch = function(e) {
      e.preventDefault();
      var ID = e.target[0].value;
      fetch(process.env.REACT_APP_API_URL+'/group/'+ID+'/entries/add', {
        method:'POST',
        headers:{
          'Content-Type': '"application/x-form-urlencoded"',
          'Authorization': 'Bearer '+localStorage.getItem('Token')
          },
        body:JSON.stringify({
          Token:localStorage.getItem('Token'),
          GroupMod:1,
          entryID:GroupOptions
        })
      })
        .then(response => response.json())
        .then(result => {
          console.log(result)
      })
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
                  {GroupSelAction !== null && 
                    <div className='groupActions'>
                      {GroupSelAction === 'add' && 
                      <>
                        <h3>Add cows to group</h3>
                        <form onSubmit={groupAddCatch}>
                        <div className='inputItem groupAddSel'>
                          <select>
                            {Object.keys(Groups).map((key, i) => (
                              <option value={Groups[key]['ID']}>{Groups[key]['GroupName']}</option>
                            ))}
                          </select>
                        </div>
                          
                          <button className='btn no-btn btn-small' onClick={()=>{setGroupAction(null)}}>Close</button>
                          <button className='btn yes-btn btn-small' type='submit'>Move</button>
                        </form>
                       
                      </>
                      }
                    </div>
                  }
                  {GroupSelAction === null && 
                    <>
                      <h3>Actions for selected items</h3>
                      <button className='btn no-btn btn-small' onClick={groupDelete}>Delete</button>
                      <button className='btn btn-small' onClick={groupMove}>Move</button>
                      <button className='btn btn-small' onClick={groupAdd}>Add to Group</button>
                    </>
                  }
                  
                  <br/>
                  <p>{GroupOptions.length} cows selected</p>
                  
                </div>
              }
              <Table stick={true} table={AllCows} UrlKey={[{title:'View',link:'/cows/', className:'btn btn-small'}]} groupSelect={true} groupList={GroupOptions} groupOnChange={handleGroupSelect}/>
            </>
            }
            
        </>
    )
}

export default CowsList
