import React, {useEffect, useState} from 'react';
import Form from "../../Form";
import { useSearchParams, Link, useNavigate } from 'react-router-dom';
function CompAdd() {
    const [formData, setFormData] = useState({});
    useEffect(() => {
      fetch('http://localhost/companies/add')
            .then(response => response.json())
            .then(result => {
              setFormData(result)
            });
    }, [])
    
    const [searchParams] = useSearchParams();
    
    let navagate = useNavigate();
    const returnFormData = async e => {
        e.preventDefault();
        const { form } = formData
        const { callBack, passwordCheck } = form;
        const FormItem = e.target;
        if(passwordCheck){
          const pass1 = FormItem.querySelector('#'+passwordCheck[0]);
          const pass2 = FormItem.querySelector('#'+passwordCheck[1]);
          if(pass1.value !== pass2.value){
            pass1.value = '';
            pass2.value = '';
            alert("Passwords Dont match");
            return
          }
        }
        
        //let FormOut = new FormData();
        let FormOut = {};
        for (let i = 0; i < FormItem.length; i++) {
            const item = FormItem[i];   
            //FormOut.append(item.name, item.value);         
            FormOut[item.name] = item.value;
        }
        if(searchParams.get('token')){
          const token = searchParams.get('token');
          FormOut['Token'] = token;
        }else{
          console.log('Please Include a token');
          return
        }
        const res = await fetch(callBack+'/add', {
            method: 'POST',
            headers:{
              'Content-Type': '"application/x-form-urlencoded"'
            },
            body: JSON.stringify(FormOut)
          });
        
        const Response = await res.json();
        if(Response.error){
          console.log(Response.error);
        }else{
           navagate('/');
        }   
    }
    return (
      <div className="container">
        <Link to='/'><button className='btn'>Home</button></Link>
        {formData.form && <Form onSubmit={returnFormData}  {...formData} />}
      </div>
    )
}

export default CompAdd
