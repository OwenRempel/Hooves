import TableBody from "./TableBody"
import TableHead from "./TableHead"
import '../../css/Table.css'

function Table({ stick, table, UrlKey }) {
    const TablePart = (parms) =>{
       const { body, info } = parms
        return(
            <table className={`BuildTable highlight ${stick && 'stick'}`}>
                <TableHead Head={info}/>
                <TableBody Body={body} UrlKey={UrlKey} />
            </table>
        )
    }
    const Locations = (props) => {
        const { data } = props
        const loc = data.Data.Locations
        return(
           <>
           {Object.keys(loc).map((i, key)=>(
                <div key={'mit'+key}>
                    <h2 key={'itm'+key}>{i}</h2>
                    <TablePart key={key} info={data.Info} body={loc[i]}/>
                </div>
           ))
           }
           </> 
        )
    }
    return (
        <div className="tableCatch">
            {!table.Data.Locations ? 
                <TablePart info={table.Info} body={table.Data}/>
                :
                <Locations data={table}/>
            }
        </div>
        
    )
}

export default Table
