import { useEffect, useState } from "react"
import { useParams } from "react-router-dom"


function GroupEntries() {
    const [ Entries, setEntries] = useState();
    const { ID } = useParams();
    useEffect(() => {
    fetch(process.env.REACT_APP_API_URL+'/group/'+ID+'/entries?token='+localStorage.getItem('Token'))
            .then(response => response.json())
            .then(result => {
            setEntries(result)
            })
    }, [ID]);
    
    function List(data, type){
        
    }
    
    

    const addEntry = (EntryID) =>{
        console.log(EntryID);
    }
  return (
    <>
        <h2>Group Items</h2>
    </>
  )
}

export default GroupEntries