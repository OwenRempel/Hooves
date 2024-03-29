import { useEffect, useState, useRef } from "react"
import { Link, useParams } from "react-router-dom"
import Back from "../../Back";



function GroupEntries() {
    const [ Entries, setEntries] = useState({});
    const [ Search, setSearch ] = useState({});
    const { ID } = useParams();
    const searchVal = useRef();
    useEffect(() => {
    fetch(process.env.REACT_APP_API_URL+'/group/'+ID+'/entries',{
      headers:{
        'Authorization': 'Bearer '+localStorage.getItem('Token')
      }
    })
            .then(response => response.json())
            .then(result => {
            setEntries(result)
            })
            return () => {
              setEntries({}); 
            };
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
    const Trow = ({row, type }) =>{
      return(
        <tr>
          {type === 'remove' &&
            <td ><span onClick={()=>removeEntry(row.ID)} className="btn no-btn btn-small">Remove</span><Link to={'/cows/'+row.ID+"?group-back="+ID} className='btn btn-small'>View</Link></td>
          }
          {type === 'add' &&
            <td ><span onClick={()=>addEntry(row.ID)} className="btn yes-btn btn-small">Add</span><Link to={'/cows/'+row.ID+"?group-back="+ID} className='btn btn-small'>View</Link></td>
          }
            {Object.keys(row).map((key, i)=>{
              if(key !== "ID"){
                return <td key={i}>{row[key]}</td>
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
            <Trow key={i} type={type} row={item} />
          ))}

        </tbody>
      )
    }
    const List = ({data, type}) =>{
      return(
        <>
          <div className="tableCatch">
            <table>
              <Thead info={data.Info}/>
              <Tbody type={type} data={data.Data}/>
            </table>
          </div>
        </>
      )
    }
    const searchEntries = (e) =>{
      var val = searchVal.current.value;
      console.log(val)
      if(val && val !== ' ' && val !== '%' && val !== '#'){
        fetch(process.env.REACT_APP_API_URL+'/cattle/search/'+val+'?group=1&limit=10',{
          headers:{
            'Authorization': 'Bearer '+localStorage.getItem('Token')
          }
        })
          .then(response => response.json())
          .then(result => {
            setSearch(result)
        })
      }
        
    }
    const removeEntry = (Entry) =>{
      fetch(process.env.REACT_APP_API_URL+'/group/'+ID+'/entries/remove', {
        method:'POST',
        headers:{
          'Content-Type': '"application/x-form-urlencoded"',
          'Authorization': 'Bearer '+localStorage.getItem('Token')
          },
        body:JSON.stringify({
          Token:localStorage.getItem('Token'),
          GroupMod:1,
          entryID:Entry
        })
      })
        .then(response => response.json())
        .then(result => {
          if(result.success){
            setEntries(result)
            searchEntries()
          }else{
            console.log(result)
          }
      })
    }

    const addEntry = (Entry) =>{

      function removeArray(Item){
        var arr = Search.Data
        var reset = Search
        var newArr = []
        arr.map((i, j)=>{
          if(i.ID !== Item){
            newArr.push(i)
          }
          return null
        })
        
        reset.Data = newArr
        setSearch(reset)
      }

      fetch(process.env.REACT_APP_API_URL+'/group/'+ID+'/entries/add', {
        method:'POST',
        headers:{
          'Content-Type': '"application/x-form-urlencoded"',
          'Authorization': 'Bearer '+localStorage.getItem('Token')
          },
        body:JSON.stringify({
          Token:localStorage.getItem('Token'),
          GroupMod:1,
          entryID:Entry
        })
      })
        .then(response => response.json())
        .then(result => {
          if(result.success){
            removeArray(Entry)
           
            setEntries(result);
            
          }else{
            console.log(result)
          }
      })
    }

  return (
    <>
      <Back link='/groups/'/>
      <h2>Group Items</h2>
      {Entries.Data &&
        <List data={Entries} type='remove'/>
      }
      
      <div className="search">
        <input type='search' ref={searchVal} className="searchInput" placeholder="Search" onKeyUp={searchEntries}/>
      </div>
      {Search.Data &&
        <List data={Search} type='add'/>
      }
    </>
  )
}

export default GroupEntries