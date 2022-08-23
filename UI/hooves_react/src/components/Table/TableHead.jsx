function TableHead({ Head, groupSelect}) {

    return (
        <thead>
            <tr>
                { groupSelect && 
                <th></th>
                }
                <th></th>
                {
                Object.keys(Head).map((key, i) => (
                    <th key={i}>{Head[key]}</th>
                    
                ))
                }
            </tr>
        </thead>
    )
}

export default TableHead
