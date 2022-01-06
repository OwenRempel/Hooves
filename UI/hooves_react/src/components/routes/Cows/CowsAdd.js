import React, {useEffect, useState} from 'react';
import Form from "../../Form";
import { formHandle } from '../../../lib/FormHandle';
import { Link } from 'react-router-dom';
function CowsAdd() {
    const [formData, setFormData] = useState({});
    useEffect(() => {
      fetch('http://localhost/cattle/info')
            .then(response => response.json())
            .then(result => {
              setFormData(result)
            });
    }, [])
    
    
    
    const returnFormData = async e => {
        e.preventDefault();
        const  res = await formHandle(formData, e.target);
        if(res.sucess){
          console.log('Cow Added Sucessfully')
          e.target.reset()
        }else{
          console.log(res)
        }
    }
    return (
      <div className="container">
        <Link to='/'><button className='btn'>Home</button></Link>
        {formData.form && <Form onSubmit={returnFormData}  {...formData} />}
      </div>
    )
}

export default CowsAdd
