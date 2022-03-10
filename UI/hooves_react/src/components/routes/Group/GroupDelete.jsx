import React, { useState } from 'react'
import { useNavigate, useParams } from 'react-router-dom';
import Back from '../../Back'


//TODO: add system to remove groups from any entries that are in the group

function GroupDelete() {
    const { ID } = useParams();
    const nav = useNavigate();
    
    const [Delete, setDelete] = useState(false);
    
    if(Delete === true){
        fetch(process.env.REACT_APP_API_URL+'/group/'+ID+'?token='+localStorage.getItem('Token'),{
            method:'DELETE'
        })
        .then(response => response.json())
        .then(result => {
            if(result.success){
                nav('/groups');
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
            <Back link={`/groups`} />
            <div className="delWrap">
                <h2>Delete</h2>
                <p>Are you sure you want to delete this Group?</p>
                <button className="btn yes-btn" onClick={del}>Yes</button>
                <button className="btn no-btn" onClick={no}>No</button>
            </div>
            
        </div>
    )
}
export default GroupDelete