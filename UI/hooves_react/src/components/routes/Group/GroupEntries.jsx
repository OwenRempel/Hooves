import { useEffect, useState } from "react"
import { useParams } from "react-router-dom"


function GroupEntries() {
    const [ Entries, setEntries] = useState({});
    const [ Search, setSearch ] = useState({});
    const { ID } = useParams();
    useEffect(() => {
    fetch(process.env.REACT_APP_API_URL+'/group/'+ID+'/entries?token='+localStorage.getItem('Token'))
            .then(response => response.json())
            .then(result => {
            setEntries(result)
            })
    }, [ID]);

    const Thead = ({info}) =>{
      return(
        <thead>
          <tr>
            <th></th>
            {Object.keys(info).map((key, i)=>{
              if(key !== "ID"){
                return <th key={i}>{info[key]}</th>
              }else{
                return null
              }
            })}
          </tr>
        </thead>
      )
    }
    const Trow = ({row, type}) =>{
      return(
        <tr>
          {type === 'remove' &&
            <td className="linkClick" onClick={()=>removeEntry(row.ID)}>Remove</td>
          }
          {type === 'add' &&
            <td className="linkClick" onClick={()=>addEntry(row.ID)}>Add</td>
          }
            {Object.keys(row).map((key, i)=>{
              if(key !== "ID"){
                return <th key={i}>{row[key]}</th>
              }else{
                return null
              }
            })}
        </tr>
      )
    }
    const Tbody = ({data, type}) =>{
      return(
        <tbody>
          {data.map((item, i)=>(
            <Trow key={i} type={type} row={item}/>
          ))}

        </tbody>
      )
    }
    const List = ({data, type}) =>{
      return(
        <>
          <table>
            <Thead info={data.Info}/>
            <Tbody type={type} data={data.Data}/>
          </table>
        </>
      )
    }
    const searchEntrys = (e) =>{
      var val = e.target.value
      if(val){
        fetch(process.env.REACT_APP_API_URL+'/cattle/search/'+val+'?token='+localStorage.getItem('Token'))
          .then(response => response.json())
          .then(result => {
            setSearch(result)
        })
      }
        
    }
    const removeEntry = (EntryID) =>{
        console.log(EntryID);
    }

    const addEntry = (EntryID) =>{
        console.log(EntryID);
    }
    console.log(Search);
  return (
    <>
        <h2>Group Items</h2>
        {Entries.Data &&
          <List data={Entries} type='remove'/>
        }
        <div className="groupSearch">
          <input type='search' onKeyUp={searchEntrys}/>
        </div>
        {Search.Data &&
          <List data={Search} type='add'/>
        }
    </>
  )
}

export default GroupEntries