import TableBody from "./TableBody"
import TableHead from "./TableHead"
import '../../css/Table.css'
import { useEffect, useState } from "react"

function Table({ stick, table, UrlKey, groupSelect = false, groupOnChange=null, groupList=null}) {
    const [Tables, setTables] = useState(null)
        useEffect(() => {
            if(table.Data.Locations){
                const locate = table.Data.Locations
                Object.keys(locate).map((item, i)=>{
                    if(i === 0){
                        setTables(item)
                    }
                    return false               
                })
            }
        }, [table])

    const TablePart = (parms) =>{
       const { body, info } = parms
        return(
            <div className="tableCatch">
                <table className={`BuildTable highlight ${stick && 'stick'}`}>
                    <TableHead Head={info} groupSelect={groupSelect}/>
                    <TableBody Body={body} UrlKey={UrlKey} groupOnChange={groupOnChange} groupList={groupList} groupSelect={groupSelect}/>
                </table>
            </div>
            
        )
    }
    const Locations = (props) => {
        const { data } = props
        const loc = data.Data.Locations
        let title = Tables
        return(
           <>
                {title &&
                    <>
                        <h2>{title}</h2>
                        <TablePart info={data.Info} body={loc[title]}/>
                    </>    
                }
           </> 
        )
    }
    const SelectTable = (props) =>{

        if(!Tables) return false
        const { items } = props
        
        const catchSelect = (e) =>{
            let val = e.target.textContent
            setTables(val)
        }
        return(
            <>
            <br></br>
                {Object.keys(items).map((i, key)=>(
                <button className={`btn btn-small ${Tables === i ? 'yes-btn' : ''}`} key={key} onClick={catchSelect}>{i}</button>
                ))}
            </>
        )
    }
    
    return (
        <>
            {!table.Data.Locations ? 
                <TablePart info={table.Info} body={table.Data}/>
                :
                <>
                    <SelectTable items={table.Data.Locations}/>
                    <Locations data={table}/>
                </>
            }
        </>
    )
}

export default Table
