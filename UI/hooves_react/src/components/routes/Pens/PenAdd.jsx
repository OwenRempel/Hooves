import React from 'react'

import { useState, useEffect } from 'react';

import Form from '../../Form'

import { formHandle } from '../../../lib/FormHandle';

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
        }else{
          console.log(res)
        }
    }

    return(
        <>
            <h3>Add pen</h3>
            {FormData.form &&  <Form {...FormData} onSubmit={submitHandle}/> }
        </>
    )
}

export default PenAdd