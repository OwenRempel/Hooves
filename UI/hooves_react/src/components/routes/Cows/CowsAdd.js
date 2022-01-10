import React, {useEffect, useState} from 'react';
import Form from "../../Form";
import { formHandle } from '../../../lib/FormHandle';
import { Link } from 'react-router-dom';
function CowsAdd() {
    const [formData, setFormData] = useState({});
    useEffect(() => {
      fetch(process.env.REACT_APP_API_URL+'/cattle/info?token='+localStorage.getItem('Token'))
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
      <div className="formWrap">
        <Link to='/'><button className='btn'>Back</button></Link>
        {formData.form && <Form onSubmit={returnFormData}  {...formData} />}
      </div>
    )
}

export default CowsAdd
