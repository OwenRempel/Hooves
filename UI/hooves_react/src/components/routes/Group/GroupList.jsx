import React, { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'
import Back from '../../Back';
import Table from '../../Table/Table';


function GroupList() {
    const [Groups, setGroups] = useState({});
    useEffect(() => {
    fetch(process.env.REACT_APP_API_URL+'/group?token='+localStorage.getItem('Token'))
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
                    title:'Add',
                    link:'/groups/entries/'
                },
                {
                    title:'Edit',
                    link:'/groups/edit/'
                },
                {
                    title:'Delete',
                    link:'/groups/delete/'
                }
            ]}/>
            }
            
        </div>
    )
}

export default GroupList