import React, {useEffect, useState} from 'react';
import Form from "../../Form";
import { formHandle } from '../../../lib/FormHandle';

import Back from '../../Back';
function CowsAdd() {
    const [formData, setFormData] = useState({});
    let feedlot = 0;
    if(localStorage.getItem('Feedlot')){
       feedlot = parseInt(localStorage.getItem('Feedlot'));
    }
    useEffect(() => {
      let feedlotChoice = '/calves';
      if(feedlot === 1){
        feedlotChoice = '/cattle';
      }
      fetch(process.env.REACT_APP_API_URL+feedlotChoice+'/info',{
        headers:{
          'Authorization': 'Bearer '+localStorage.getItem('Token'),
        }
      })
            .then(response => response.json())
            .then(result => {
              setFormData(result)
            });
    }, [feedlot])
    
    
    
    const returnFormData = async e => {
        window.scrollTo(0, 0)
        e.preventDefault();
        const  res = await formHandle(formData, e.target);
        if(res.success){
          console.log('Cow Added successfully')
          e.target.reset()
        }else{
          console.log(res)
        }
    }

    return (
      <div className="formWrap">
        <Back link='/'/>
        {formData.form && <Form onSubmit={returnFormData}  {...formData} />}
      </div>
    )
}

export default CowsAdd
