import React, {useEffect, useState } from 'react';
import Form from "../../Form";
import Back from "../../Back";

function CompAdd() {
    const [formData, setFormData] = useState({});
    useEffect(() => {
      fetch('http://localhost/companies/add')
            .then(response => response.json())
            .then(result => {
              setFormData(result)
            });
    }, [])
        
    
    
    
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
          console.log('sucess')
        }
        
        
       
        
    }
    return (
      <div className="container">
        <Back link='/companies' />
        {formData.form && <Form onSubmit={returnFormData}  {...formData} />}
      </div>
    )
}

export default CompAdd
