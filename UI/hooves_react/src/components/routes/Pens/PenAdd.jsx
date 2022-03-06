import React from 'react'

import { useState, useEffect } from 'react';

import Form from '../../Form'

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

    const submitHandle = (e) =>{
        e.preventDefault();
        console.log('form handle')
    }

    return(
        <>
            <h3>Add pen</h3>
            {FormData.form &&  <Form {...FormData} onSubmit={submitHandle}/> }
        </>
    )
}

export default PenAdd