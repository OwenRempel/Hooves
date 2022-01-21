import { useParams, useNavigate } from "react-router-dom"
import { useState} from "react";
import Back from "../../Back";


function CowDelete() {
    const { ID } = useParams();
    const nav = useNavigate();
    
    const [Delete, setDelete] = useState(false);
    
    if(Delete === true){
        fetch(process.env.REACT_APP_API_URL+'/cattle/'+ID+'?token='+localStorage.getItem('Token'),{
            method:'DELETE'
        })
        .then(response => response.json())
        .then(result => {
            if(result.success){
                nav('/cows');
            }
        });
    }
    const del = () => {
        setDelete(true);
    }
    const no = () => {
        nav('/cows');
    }
    return (
        <div>
            <Back link={`/cows/${ID}`} />
            <div className="delWrap">
                <h2>Delete</h2>
                <p>Are you sure you want to delete this cow?</p>
                <button className="btn yes-btn" onClick={del}>Yes</button>
                <button className="btn no-btn" onClick={no}>No</button>
            </div>
            
        </div>
    )
}

export default CowDelete
