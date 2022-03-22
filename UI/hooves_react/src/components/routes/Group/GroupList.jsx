import React, { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'
import Back from '../../Back';
import Table from '../../Table/Table';


function GroupList() {
    const [Groups, setGroups] = useState({});
    useEffect(() => {
    fetch(process.env.REACT_APP_API_URL+'/group',{
        headers:{
            'Authorization': 'Bearer '+localStorage.getItem('Token')
          }
    })
            .then(response => response.json())
            .then(result => {
            setGroups(result)
            })
    }, []);
    return (
        <div>
            <Back link='/'/>
            <h1>All Cattle</h1>
            <Link to='/groups/add' className='btn'>Add Group</Link>
            {Groups.Data &&
            <Table table={Groups} UrlKey={[
                {
                    title:'Entries',
                    link:'/groups/entries/',
                    className:'btn yes-btn btn-small'
                },
                {
                    title:'Edit',
                    link:'/groups/edit/',
                    className:'btn  btn-small'
                },
                {
                    title:'Delete',
                    link:'/groups/delete/',
                    className:'btn no-btn  btn-small'
                }
            ]}/>
            }
            
        </div>
    )
}

export default GroupList