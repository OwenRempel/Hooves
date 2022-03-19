import React from 'react'

import { useState, useEffect } from 'react'
import { Link, Outlet } from 'react-router-dom';

import { formHandle } from '../../../lib/FormHandle';
import Back from '../../Back';
import Form from '../../Form';








function Pens() {
  const [Nav, setNav] = useState(false)

  function PenAdd() {
    const [FormData, setFormData] = useState({})
    useEffect(() => {
        fetch(process.env.REACT_APP_API_URL+'/pens/info?token='+localStorage.getItem('Token'))
              .then(response => response.json())
              .then(result => {
                setFormData(result)
               
              });
      }, [])

    console.log(FormData)

    const  submitHandle = async (e) =>{
        e.preventDefault();
        const  res = await formHandle(FormData, e.target);
        if(res.success){
          console.log('Pen Added successfully')
          e.target.reset()
          setNav(false)
        }else{
          console.log(res)
        }
    }

    return(
        <>
            {FormData.form &&  <Form {...FormData} onSubmit={submitHandle}/> }
        </>
    )
  }

  function PenList() {
    const [AllCows, setAllCows] = useState({});
    useEffect(() => {
      fetch(process.env.REACT_APP_API_URL+'/pens?token='+localStorage.getItem('Token'))
            .then(response => response.json())
            .then(result => {
              setAllCows(result)
            })
    }, []);
    var data = null
    if(AllCows.Data) data = AllCows.Data
    
    function Builder(data){
      return(
        <>
        
          {
            data.map((item, i)=>(
              <div key={i} className='penItems'>
                <Link className='btn btn-small' to={`/settings/pens/edit/${item.ID}`}>Edit</Link>
                <Link className='btn btn-small no-btn' to={`/settings/pens/delete/${item.ID}`}>Delete</Link>
                <h3>{item.Name}</h3>
              </div>
            ))
          }
        </>
      )
    }
    
    return(
      <>
      
        {data &&
        <>
          <h2>All pens</h2>
          {Builder(data)}
        </>
        }
      </>
    )
  }

  return (
      <>
      <Back link='/settings/'/>
        <h1>Pens</h1>
        <button className='btn btn-small' onClick={() => {setNav(!Nav)}}>{!Nav ? 'Add' : 'Close'}</button>
        {Nav && <PenAdd/>}
        <Outlet/>
        <PenList/>
      </>
  )
}

export default Pens