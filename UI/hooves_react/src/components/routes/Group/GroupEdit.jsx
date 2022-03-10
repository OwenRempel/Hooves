import React, { useEffect, useState } from 'react'
import { useNavigate, useParams } from 'react-router-dom';
import { formHandle } from '../../../lib/FormHandle';
import Back from '../../Back'
import Form from '../../Form';




function GroupEdit() {
    const { ID } = useParams();
    const nav = useNavigate();
    const [FormData, setFormData] = useState({})
    useEffect(() => {
        fetch(process.env.REACT_APP_API_URL+'/group/info/'+ID+'?token='+localStorage.getItem('Token'))
              .then(response => response.json())
              .then(result => {
                setFormData(result)
               
              });
      }, [ID])

    console.log(FormData)

    const  submitHandle = async (e) =>{
        e.preventDefault();
        const  res = await formHandle(FormData, e.target, 'PUT');
        if(res.success){
          console.log('Group Updated successfully')
          e.target.reset()
          nav('/groups')
        }else{
          console.log(res)
        }
    }

    return(
        <>
            <Back link='/groups'/>
            {FormData.form &&  <Form {...FormData} onSubmit={submitHandle}/> }
        </>
    )
}

export default GroupEdit