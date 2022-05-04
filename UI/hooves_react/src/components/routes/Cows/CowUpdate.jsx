import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom"
import { formHandle } from "../../../lib/FormHandle";
import Form from "../../Form";
import Back from "../../Back";

function  CowUpdate() {
    const { ID } = useParams();
    const [formData, setFormData] = useState({});
    const nav = useNavigate();
    let feedlot = 0;
    if(localStorage.getItem('Feedlot')){
       feedlot = parseInt(localStorage.getItem('Feedlot'));
    }
    useEffect(() => {
        let feedlotChoice = '/calves';
        if(feedlot === 1){
            feedlotChoice = '/cattle';
        }
      fetch(process.env.REACT_APP_API_URL+feedlotChoice+'/info/'+ID,{
        headers:{
            'Authorization': 'Bearer '+localStorage.getItem('Token'),
          }
      })
            .then(response => response.json())
            .then(result => {
              setFormData(result)
            });
    }, [ID, feedlot])
    const returnFormData = async (e) => {
        e.preventDefault();
        const  res = await formHandle(formData, e.target, 'PUT');
        if(res.success){
            nav('/cows/'+ID);
        }
    }
    
    return (
        <div>
            <Back link={`/cows/${ID}`} />
            {formData.form && <Form onSubmit={returnFormData}  {...formData} />}
        </div>
    )
}

export default CowUpdate
