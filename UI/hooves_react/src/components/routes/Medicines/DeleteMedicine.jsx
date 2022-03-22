import Back from "../../Back";
import { useParams, useNavigate } from "react-router-dom";
import { useState } from "react";
function DeleteMedicine() {
    const nav = useNavigate();
    const {Cow, ID} = useParams()
    const [Delete, setDelete] = useState(false);
    
    if(Delete === true){
        fetch(process.env.REACT_APP_API_URL+'/medical/'+ID,{
            method:'DELETE',
            headers:{
                'Authorization': 'Bearer '+localStorage.getItem('Token')
              }
        })
        .then(response => response.json())
        .then(result => {
            console.log(result)
            if(result.success){
                nav(`/cows/${Cow}`);
            }
        });
    }
    const del = () => {
        setDelete(true);
    }
    const no = () => {
        nav(`/cows/${Cow}`)
    }
  return(
    <div>
        <Back link={`/cows/${Cow}`}  />  
        <div className="delWrap">
            <h2>Delete</h2>
            <p>Are you sure you want to delete this Medical Entry?</p>
            <button className="btn yes-btn" onClick={del}>Yes</button>
            <button className="btn no-btn" onClick={no}>No</button>
        </div>
    </div>
  );
}

export default DeleteMedicine;
